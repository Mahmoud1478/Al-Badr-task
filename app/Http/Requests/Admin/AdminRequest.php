<?php

namespace App\Http\Requests\Admin;

use App\Rules\PermissionExists;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $admin_id = auth('admin')->id();
        switch ($this->method()){

            case 'PATCH':
            case 'PUT':
                abort_unless(in_array($admin_id,[$this->user->id , 1]), 404);
                break;
            case 'GET':
            case'HEAD' :
            case 'POST':
               if ($this->routeIs('admin.users.create')|| $this->routeIs('admin.users.store')){
                   abort_unless($admin_id == 1, 404);
                   break;
               }
                abort_unless(in_array($admin_id,[$this->user->id , 1]), 404);
                break;
            case 'DELETE' :
                abort_unless($admin_id == 1, 404);
                break;
            default:
                break;

        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $base = [
            'name'=> ['required','max:255'],
            'permissions'=>['array'],
            'permissions.*'=> ['nullable', new PermissionExists()]
        ];
        return match ($this->method()){
            'POST' => array_merge($base,[
                'email' => ['required','email','unique:users,email'],
                'password' => ['required','min:6','confirmed'],
            ]),
            'PUT','PATCH'=> array_merge($base,[
                'email' => ['required','email','unique:users,email,'.$this->user->id],
                'password' => ['nullable','min:6','confirmed'],
            ]),
            default => []
        };
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'permissions' => $this->get('permissions',[])
        ]);
    }
}
