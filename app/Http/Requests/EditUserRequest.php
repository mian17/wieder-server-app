<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|min:3|max:64|unique:user,username',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
            'email' => 'required|email|max:255|unique:user,email',
            'phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15',
                'unique:user,phone_number'
            ],
            'name' => 'required|min:4|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|integer|numeric|between:1,3',
            'address' => 'required|string|max:255',
            'role_id' => 'required|numeric|integer|between:1,3',
        ];
    }
}
