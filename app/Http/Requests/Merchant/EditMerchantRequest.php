<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class EditMerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO:: TURN OFF AFTER TESTING
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
            'name' => 'required|string|min:2|max:64',
            'address' => 'required|string|min:2|max:255',
            'phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15',
            ],
            'email' => 'required|email|max:255',
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
            'name.required' => 'Bạn cần nhập tên của nhà bán',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên nhà bán ngắn quá',
            'name.max' => 'Tên nhà bán dài quá',

            'address.required' => 'Bạn cần nhập địa chỉ của nhà bán',
            'address.string' => 'Sai dữ liệu',
            'address.min' => 'Địa chỉ nhà bán ngắn quá',
            'address.max' => 'Địa chỉ nhà bán dài quá',

            'phone_number.required' => 'Bạn chưa nhập số điện thoại của nhà bán',
            'phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'phone_number.max' => 'Số điện thoại của bạn dài quá',

            'email.required' => "Bạn cần nhập email",
            'email.email' => "Dữ liệu bạn nhập không đúng định dạng email",
            'email.max' => "Email bạn nhập dài quá",
        ];
    }
}
