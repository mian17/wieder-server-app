<?php

namespace App\Http\Requests\Kind;

use Illuminate\Foundation\Http\FormRequest;

class EditKindRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:64',
            'image_1' => 'string|min:2|max:255',
            'image_2' => 'string|min:2|max:255',

            'hex_color' => [
                'required',
                'string',
                'min:4',
                'max:7',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],

            "product_id" => "required|integer|numeric|min:1",

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
            'name.required' => 'Bạn cần nhập tên của loại hàng',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên loại hàng ngắn quá',
            'name.max' => 'Tên loại hàng dài quá',

//            'image_1.required' => 'Bạn cần nhập hình static cho sản phẩm, hình thứ 2 (on hover) có thể để trống nếu đây không phải là kiểu mẫu mặc định của sản phẩm',
            'image_1.string' => 'Sai dữ liệu',
            'image_1.min' => 'Sai dữ liệu',
            'image_1.max' => 'Sai dữ liệu',


            'image_2.string' => 'Sai dữ liệu',
            'image_2.min' => 'Sai dữ liệu',
            'image_2.max' => 'Sai dữ liệu',

            'hex_color.required' => 'Bạn cần nhập màu hex cho loại sản phẩm',
            'hex_color.string' => 'Sai dữ liệu',
            'hex_color.min' => 'Màu cần đúng định dạng: #fff hoặc #ffffff',
            'hex_color.max' => 'Màu cần đúng định dạng: #fff hoặc #ffffff',
            'hex_color.regex' => 'Màu cần đúng định dạng: #fff hoặc #ffffff',

            'product_id.required' => 'Bạn cần nhập loại sản phẩm này thuộc sản phẩm nào',
            'product_id.integer' => 'Sai dữ liệu',
            'product_id.numeric' => 'Sai dữ liệu',
            'product_id.min' => 'Sai dữ liệu',

        ];
    }
}
