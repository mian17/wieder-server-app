<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO: TURN THIS OFF AFTER TESTING
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
            'name' => 'required|string|min:2|max:64|unique:payment_method,name',

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
            'name.required' => 'Bạn cần nhập tên của phương thức thanh toán',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên phương thức thanh toán ngắn quá',
            'name.max' => 'Tên phương thức thanh toán dài quá',
            'name.unique' => 'Tên phương thức thanh toán này đã tồn tại',
        ];
    }
}
