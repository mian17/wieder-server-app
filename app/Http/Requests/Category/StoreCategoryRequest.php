<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:64|unique:category,name',
            'img_file' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'parent_category_id' => 'integer|numeric|min:0',
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
            'name.required' => 'Bạn cần nhập tên danh mục sản phẩm',
            'name.string' => 'Sai dữ liệu',
            'name.min' => 'Tên danh mục sản phẩm ngắn quá',
            'name.max' => 'Tên danh mục sản phẩm dài quá',
            'name.unique' => 'Tên danh mục sản phẩm này đã tồn tại',

            'img_file.required' => 'Bạn cần nhập hình',
            'img_file.image' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'img_file.mimes' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'img_file.max' => 'Kích cỡ hình cần dưới 2MB',

            'parent_category_id.integer' => 'Sai dữ liệu',
            'parent_category_id.numeric' => 'Sai dữ liệu',
            'parent_category_id.min' => 'Sai dữ liệu',

        ];
    }
}
