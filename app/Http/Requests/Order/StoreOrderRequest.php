<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_uuid' => 'nullable|string|min:2|max:64',
            'receiver_name' => 'required|string|min:2|max:255',
            'receiver_email' => 'required|string|min:2|max:255',
            'receiver_phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15',
            ],
            'receiver_address' => 'required|string|min:2|max:255',
            'total' => 'required|integer|numeric|min:1000',
//            'status_id' => 'required|integer|numeric',
            'payment_method_id' => 'required|integer|numeric',
            'cart' => 'required|array|min:1',
            'discount_code' => 'nullable|string|min:1',
            'discount_percent' => 'nullable|numeric|integer',
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
            'user_uuid.string' => 'Sai dữ liệu',
            'user_uuid.min' => 'Sai dữ liệu',
            'user_uuid.max' => 'Sai dữ liệu',

            'receiver_name.required' => 'Vui lòng nhập họ và tên người nhận',
            'receiver_name.string' => 'Sai dữ liệu',
            'receiver_name.min' => 'Họ và tên người nhận ngắn quá',
            'receiver_name.max' => 'Họ và tên người nhận dài quá',

            'receiver_email.required' => 'Bạn cần nhập email của người nhận',
            'receiver_email.email' => 'Sai định dạng email',
            'receiver_email.string' => 'Sai dữ liệu',
            'receiver_email.min' => 'Email người nhận ngắn quá',
            'receiver_email.max' => 'Email người nhận dài quá',

            'receiver_phone_number.required' => 'Vui lòng nhập số điện thoại của người nhận',
            'receiver_phone_number.regex' => 'Số điện thoại bạn nhập không đúng định dạng',
            'receiver_phone_number.max' => 'Số điện thoại bạn nhập dài quá',

            'receiver_address.required' => 'Vui lòng nhập địa chỉ người nhận',
            'receiver_address.string' => 'Sai dữ liệu',
            'receiver_address.min' => 'Địa chỉ bạn nhập ngắn quá',
            'receiver_address.max' => 'Địa chỉ bạn nhập dài quá',

            'total.required' => 'Thiếu thông tin tổng số tiền trong giỏ hàng',
            'total.integer' => 'Sai dữ liệu',
            'total.numeric' => 'Sai dữ liệu',
            'total.min' => 'Sai dữ liệu',

            'payment_method_id.required' => 'Thiếu thông tin phương thức thanh toán',
            'payment_method_id.integer' => 'Sai dữ liệu',
            'payment_method_id.numeric' => 'Sai dữ liệu'
        ];
    }
}
