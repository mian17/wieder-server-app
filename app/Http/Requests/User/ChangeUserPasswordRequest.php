<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO: TURN OFF AFTER TESTING
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|string|min:8',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
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
            'old_password.required' => 'Bạn cần nhập mật khẩu cũ của bạn',
            'old_password.string' => 'Không đúng dữ liệu',
            'old_password.min' => 'Mật khẩu phải dài hơn 8 ký tự',

            'password.required' => "Bạn cần nhập mật khẩu mới của bạn",
            'password.confirmed' => "Mật khẩu mới không giống nhau",
            'password.min' => "Mật khẩu mới cần ít nhất 8 ký tự",
            'password.regex' => "Mật khẩu mới cần có ít nhất 1 chữ thường, 1 chữ in hoa, 1 chữ số và 1 ký tự đặc biệt",
        ];
    }
}
