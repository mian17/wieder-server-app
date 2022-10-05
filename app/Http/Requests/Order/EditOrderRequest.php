<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class EditOrderRequest extends FormRequest
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
            'receiver_name' => 'required|string|min:2|max:255',
            'receiver_email' => 'required|email|string|min:2|max:255',
            'receiver_phone_number' => [
                'required',
                'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/',
                'max:15',
            ],
            'receiver_address' => 'required|string|min:2|max:255',
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
            'receiver_name.required' => 'Bạn cần nhập họ và tên của người nhận',
            'receiver_name.string' => 'Sai dữ liệu',
            'receiver_name.min' => 'Họ và tên của người nhận cần hơn 2 ký tự',
            'receiver_name.max' => 'Họ và tên của người nhận cần ít hơn 255 ký tự',

            'receiver_email.required' => 'Bạn cần nhập họ và tên của người nhận',
            'receiver_email.email' => 'Thông tin email của người nhận không đúng định dạng email',
            'receiver_email.string' => 'Sai dữ liệu',
            'receiver_email.min' => 'Họ và tên của người nhận cần hơn 2 ký tự',
            'receiver_email.max' => 'Họ và tên của người nhận cần ít hơn 255 ký tự',

            'receiver_phone_number.required' => 'Bạn cần nhập số điện thoại người nhận',
            'receiver_phone_number.regex' => 'Số điện thoại của người nhận không đúng định dạng',
            'receiver_phone_number.max' => 'Số điện thoại của người nhận cần ít hơn 15 ký tự',

            'receiver_address.required' => 'Bạn cần nhập địa chỉ của người nhận',
            'receiver_address.string' => 'Sai dữ liệu',
            'receiver_address.min' => 'Địa chỉ của người nhận cần dài hơn 2 ký tự',
            'receiver_address.max' => 'Địa chỉ của người nhận cần ít hơn 255 ký tự',
        ];
    }
}
