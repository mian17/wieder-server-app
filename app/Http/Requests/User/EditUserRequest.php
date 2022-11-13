<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
        $userUuid = auth('sanctum')->user()->uuid;

        return [
            'username' => 'required|min:3|max:64|unique:user,username,' . $userUuid . ',uuid',
            'email' => 'required|email|max:255|unique:user,email,'  . $userUuid . ',uuid',
            'phone_number' => [
                'required',
//                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'regex:/(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8})\b/',
                'max:15',
                'unique:user,phone_number,'  . $userUuid . ',uuid',
            ],
            'name' => 'required|min:4|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|integer|numeric|between:0,2',
            'address' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Bạn cần nhập tên người dùng',
            'username.max' => 'Tên người dùng của bạn dài quá',
            'username.min' => 'Tên người dùng của bạn ngắn quá',
            'username.unique' => 'Tên người dùng này đã được dùng để đăng ký',

            'email.required' => "Bạn cần nhập email",
            'email.email' => "Dữ liệu bạn nhập không đúng định dạng email",
            'email.max' => "Email bạn nhập dài quá",
            'email.unique' => 'Email này đã được đăng ký',

            'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'phone_number.max' => 'Số điện thoại của bạn dài quá',
            'phone_number.unique' => 'Số điện thoại này đã được sử dụng để đăng ký',
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
