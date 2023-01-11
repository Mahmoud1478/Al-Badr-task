<?php

namespace App\Http\Requests\Admin;

use App\Rules\Between;
use App\Rules\EGPhoneRule;
use App\Rules\FloatRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
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
            'phone' => ['required', new EGPhoneRule()],
            'first_name' => ['required','max:255'],
            'last_name' => ['required','max:255'],
            'mid_name' => ['nullable','max:255'],
            'drive_licence' => ['nullable','image','max:5000'],
            'longitude' => ['required',new FloatRule,new Between(min:-180,max:180)],
            'latitude' => ['required',new FloatRule,new Between(min:-90,max:90)],
        ];
        return match ($this->method()){
            'POST' => array_merge($base,[
                'email'=> ['required','email','unique:clients,email'],
                'image' => ['required','image','max:5000'],
                'password'=> ['required','confirmed','min:6']
            ]),
            'PUT','PATCH' => array_merge($base , [
                'email'=> ['required','email','unique:clients,email,'.$this->client->id],
                'image' => ['nullable','image','max:5000'],
                'password'=> ['nullable','confirmed','min:6']
            ])
        };
    }

}
