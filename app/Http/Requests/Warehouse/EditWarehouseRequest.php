<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class EditWarehouseRequest extends FormRequest
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
            'name.required' => 'Bạn cần nhập tên của nhà kho',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên nhà kho ngắn quá',
            'name.max' => 'Tên nhà kho dài quá',

            'address.required' => 'Bạn cần nhập địa chỉ của nhà kho',
            'address.string' => 'Sai dữ liệu',
            'address.min' => 'Địa chỉ nhà kho ngắn quá',
            'address.max' => 'Địa chỉ nhà kho dài quá',

            'phone_number.required' => 'Bạn chưa nhập số điện thoại của nhà kho',
            'phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'phone_number.max' => 'Số điện thoại của bạn dài quá',

            'email.required' => "Bạn cần nhập email",
            'email.email' => "Dữ liệu bạn nhập không đúng định dạng email",
            'email.max' => "Email bạn nhập dài quá",
        ];
    }
}
