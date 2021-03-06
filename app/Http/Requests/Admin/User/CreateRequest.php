<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
            'roles_list'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'password.required'=>'Password is required',
            'password_confirmation.required'=>'Password Confirmation is required',
            'roles_list.required'=>'Role are required',
        ];
    }
}
