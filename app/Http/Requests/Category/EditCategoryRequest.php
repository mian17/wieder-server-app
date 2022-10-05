<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class EditCategoryRequest extends FormRequest
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
        $categoryId = $this->route('id');
        return [
            'name' => 'required|string|min:2|max:64|unique:category,name,' . $categoryId,
            'image' => $this->getValidationRule('image'),
            'parent_category_id' => 'nullable|integer|numeric|min:0|exists:category,id',
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
            'name.min' => 'Tên danh mục sản phẩm ngắn quá',
            'name.max' => 'Tên danh mục sản phẩm dài quá',
            'name.unique' => 'Tên danh mục sản phẩm này đã tồn tại',


            'image.required' => 'Thiếu thông tin',
            'image.image' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'image.dimensions' => 'Hình của bạn cần có tỉ lệ 16:9',
            'image.max' => 'Kích cỡ hình cần dưới 2MB',
            'image.string' => 'Sai dữ liệu',

            'parent_category_id.integer' => 'Sai dữ liệu',
            'parent_category_id.numeric' => 'Sai dữ liệu',
            'parent_category_id.min' => 'Sai dữ liệu',
            'parent_category_id.exists' => 'Sai dữ liệu'
        ];
    }

    public function getValidationRule(String $key): string
    {
        if (request()->hasFile($key)) {
            return "required|image|mimes:png,jpg,jpeg|dimensions:ratio=16/9|max:2048";
        }
        return "required|string";
    }
}
