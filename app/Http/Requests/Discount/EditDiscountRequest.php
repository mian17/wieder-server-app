<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class EditDiscountRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:64|unique:discount,name',
            'desc' => 'required|string|min:4|max:255',
            'total_money_condition' => 'required|integer|numeric|min:1000',
            'discount_percent' => 'required|integer|numeric|min:1|max:100',

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
            'name.required' => 'Bạn cần nhập code mã giảm giá ',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Code mã giảm giá cần dài hơn 4 ký tự',
            'name.max' => 'Code mã giảm giá dài quá',
            'name.unique' => 'Code mã giảm giá này đã tồn tại',

            'desc.required' => 'Bạn cần nhập thông tin mô tả cho mã giảm giá',
            'desc.string' => 'Sai dữ liệu',
            'desc.min' => 'Thông tin cho mã giảm giá ngắn quá',
            'desc.max' => 'Thông tin cho mã giảm giá dài quá',

            'total_money_condition.required' => 'Bạn cần nhập điều kiện tổng số tiền của giỏ hàng cần thiết để áp dụng mã giảm giá',
            'total_money_condition.integer' => 'Sai dữ liệu',
            'total_money_condition.numeric' => 'Sai dữ liệu',
            'total_money_condition.min' => 'Điều kiện tổng số tiền của giỏ hàng cần thiết cần trên 1000 VNĐ',

            'discount_percent.required' => 'Bạn cần nhập số phần trăm giảm giá để áp dụng cho tổng đơn hàng',
            'discount_percent.integer' => 'Sai dữ liệu',
            'discount_percent.numeric' => 'Sai dữ liệu',

            'discount_percent.min' => 'Số phần trăm giảm cần trên 1%',
            'discount_percent.max' => 'Số phần trăm giảm cần dưới 100%',
        ];
    }
}
