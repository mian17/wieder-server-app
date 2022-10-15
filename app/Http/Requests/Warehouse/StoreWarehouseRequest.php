<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user->tokenCan('admin') || $user->tokenCan('moderator');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:64|unique:warehouse,name',
            'address' => 'required|string|min:2|max:255|unique:warehouse,address',
            'phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15',
                'unique:warehouse,phone_number'
            ],
            'email' => 'required|email|max:255|unique:warehouse,email',
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
            'name.unique' => 'Tên nhà kho này đã tồn tại',

            'address.required' => 'Bạn cần nhập địa chỉ của nhà kho',
            'address.string' => 'Sai dữ liệu',
            'address.min' => 'Địa chỉ nhà kho ngắn quá',
            'address.max' => 'Địa chỉ nhà kho dài quá',
            'address.unique' => 'Địa chỉ nhà kho này đã tồn tại',

            'phone_number.required' => 'Bạn chưa nhập số điện thoại của nhà kho',
            'phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'phone_number.max' => 'Số điện thoại của bạn dài quá',
            'phone_number.unique' => 'Số điện thoại của nhà kho này đã được sử dụng để đăng ký',

            'email.required' => "Bạn cần nhập email",
            'email.email' => "Dữ liệu bạn nhập không đúng định dạng email",
            'email.max' => "Email bạn nhập dài quá",
            'email.unique' => 'Email này đã được đăng ký',
        ];
    }
}
