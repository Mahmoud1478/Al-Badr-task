<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Permission;
use App\Http\Requests\Admin\ClientRequest;
use App\Jobs\OTPJop;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Exceptions\Exception;

class ClientController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        abort_if(!auth('admin')->user()->canAny(Permission::keys()),404);
        return view('admin.clients.index');
    }

    /**
     * @param Client $client
     * @return View
     */
    public function edit(Client $client) : View
    {
        abort_if(!auth('admin')->user()->can('update-clients'),404);
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * @param ClientRequest $request
     * @return RedirectResponse
     */
    public function update(ClientRequest $request,Client $client): RedirectResponse
    {
        abort_if(!auth('admin')->user()->can('update-clients'),404);
        $data = $request->validated();
        $client->update($data);
        return redirect()->route('admin.clients.index')->with('success','data saved successfully');
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('admin.clients.create');
    }
    /**
     * @param ClientRequest $request
     * @return RedirectResponse
     */
    public function store(ClientRequest $request):RedirectResponse
    {
        abort_if(!auth('admin')->user()->can('create-clients'),404);
        $data = $request->validated();
        $client = Client::create($data);
        $otp = $client->otp()->create();
        $this->dispatch(new OTPJop($client,$otp));
        return redirect()->route('admin.clients.index')->with('success','data saved successfully');
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function toggle(Client $client): JsonResponse
    {
        abort_if(!auth('admin')->user()->can('activate-clients'),404);
        if ($client->hasVerifiedEmail()){
            $client->markEmailAsUnverified();
            return response()->json(['msg'=> 'Email unverified successfully']);
        }
        $client->markEmailAsVerified();
        $client->otp()->delete();
        return response()->json(['msg'=> "Email verified successfully"]);
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        abort_if(
            !auth('admin')->user()->can('create-clients'),
            403,
            'you don\'t have permission to do this action');
        $client->delete();
        return response()->json(['msg'=> "data deleted successfully"]);
    }

    /**
     * @throws Exception
     * @return JsonResponse
     */
    public function datatable(): JsonResponse
    {
        abort_if(!auth('admin')->user()->canAny(Permission::keys()),404);
        return datatables()->eloquent(Client::query()
            ->select(['id','first_name','mid_name','last_name','email','phone','email_verified_at'])
        )
            ->addColumn('email_verified_at',fn(Client $client) => $client->email_verified_at?->format('D, d M Y H:i:s'))
            ->addColumn('full_name',fn(Client $client) => $client->full_name )
            ->addColumn('actions',function (Client $row){
                $admin= auth('admin')->user();
                $status = null;
                $edit = null;
                $delete = null;
                if ($admin->can('update-clients')){
                    $edit = '<a href="'.route('admin.clients.edit',$row->id).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
                }
                if ($admin->can('activate-clients')){

                    if ($row->hasVerifiedEmail()){
                        $status = '<button  data-url = '.route('admin.clients.toggle_status',$row->id).' class="btn toggle btn-warning"><i style="pointer-events: none" class="fa fa-times"></i></button>';
                    }else{
                        $status = '<button data-url = '.route('admin.clients.toggle_status',$row->id).'  class="btn toggle btn-success"><i style="pointer-events: none" class="fa fa-check"></i></button>';
                    }
                }
                if ($admin->can('delete-clients')) {
                    $delete = '<button data-url = ' . route('admin.clients.destroy', $row->id) . ' class="btn delete-btn btn-danger"><i style="pointer-events: none" class="fa fa-trash"></i></button>';
                }
                return $edit.' '.$status.' '.$delete;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
