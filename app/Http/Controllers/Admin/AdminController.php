<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use Yajra\DataTables\Exceptions\Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(AdminRequest $request) :View
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminRequest $request
     * @return RedirectResponse
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect()->route('admin.users.index')->with('success','data saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user,AdminRequest $request): View
    {
        return view('admin.admins.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(AdminRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if (auth('admin')->id() != 1) $data['permissions'] = $user->permissions ;
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','data saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user,AdminRequest $request)
    {
        $user->delete();
        return response()->json(['msg'=> "data deleted successfully"]);
    }

    /**
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        return datatables()->eloquent(User::query()->select(['id','name','email'])->where('id','!=',1))
            ->addColumn('actions',function (User $row){
                $owner= auth('admin')->id() == 1;
                $edit = null;
                $delete = null;
                if ($owner || auth('admin')->id() == $row->id){
                    $edit = '<a href="'.route('admin.users.edit',$row->id).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
                }
                if ($owner) {
                    $delete = '<button data-url = ' . route('admin.users.destroy', $row->id) . ' class="btn delete-btn btn-danger"><i style="pointer-events: none" class="fa fa-trash"></i></button>';
                }
                return $edit.' '.$delete;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
