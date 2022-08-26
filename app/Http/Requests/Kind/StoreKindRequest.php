<?php

namespace App\Http\Requests\Kind;

use Illuminate\Foundation\Http\FormRequest;

class StoreKindRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:64|unique:model,name',
            'image_file_1' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'image_file_2' => 'image|mimes:png,jpg,jpeg|max:2048',

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
            'name.unique' => 'Tên loại hàng này đã tồn tại',

            'image_file_1.required' => 'Bạn cần nhập hình đối với hình static, hình on hover có thể không cần',
            'image_file_1.image' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'image_file_1.mimes' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'image_file_1.max' => 'Kích cỡ hình cần dưới 2MB',

            'image_file_2.image' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'image_file_2.mimes' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'image_file_2.max' => 'Kích cỡ hình cần dưới 2MB',

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
