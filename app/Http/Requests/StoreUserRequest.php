<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => 'required|max:64',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]$/',
            'email' => 'required|email|max:255',
            'phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15'
            ],
            'name' => 'required|min:4|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|integer|numeric|between:0,2',
            'address' => 'required|string|max:255'
//            'last_name' => 'required|min:2|max:255',
//            'first_name' => 'required|min:'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Bạn cần nhập tên người dùng',
            'username.max' => 'Tên người dùng của bạn dài quá',
            'password.required' => "Bạn cần nhập mật khẩu",
            'password.confirmed' => "Mật khẩu không giống nhau",
            'password.min' => "Mật khẩu cần ít nhất 8 ký tự",
            'password.regex' => "Mật khẩu cần có ít nhất 1 chữ thường, 1 chữ in hoa, 1 chữ số và 1 ký tự đặc biệt",
            'email.required' => "Bạn cần nhập email",
            'email.email' => "Dữ liệu bạn nhập không đúng định dạng email",
            'email.max' => "Email bạn nhập dài quá",
            'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'phone_number.max' => 'Số điện thoại của bạn dài quá',
            'name.required' => 'Bạn cần nhập đầy đủ họ và tên',
            'name.min' => 'Họ và tên của bạn ngắn quá',
            'name.max' => 'Họ và tên của bạn dài quá',
            'birth_date.required' => 'Bạn cần nhập ngày sinh của bạn',
            'birth_date.date' => 'Ngày sinh của bạn không đúng định dạng ngày',
            'gender.required' => 'Bạn chưa nhập giới tính của bạn',
            'gender.integer' => 'Sai dữ liệu',
            'gender.numeric' => 'Sai dữ liệu',
            'gender.between' => 'Sai dữ liệu',
            'address.required' => 'Bạn cần nhập địa chỉ của bạn',
            'address.string' => 'Sai kiểu dữ liệu của địa chỉ',
            'address.max' => 'Địa chỉ của bạn dài quá',


        ];
    }
}
