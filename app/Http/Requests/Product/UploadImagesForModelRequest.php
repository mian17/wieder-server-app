<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UploadImagesForModelRequest extends FormRequest
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
            'product_id' => 'required|integer|numeric|exists:product,id',
            'model_id' => 'required|integer|numeric|exists:model,id',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:png,jpg,jpeg|dimensions:ratio=1|max:2048',
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
            'product_id.required' => 'Bạn cần chọn sản phẩm mà bạn cần đăng hình ảnh',
            'product_id.integer' => 'Sai dữ liệu',
            'product_id.numeric' => 'Sai dữ liệu',
            'product_id.exists' => 'Sai dữ liệu',

            'model_id.required' => 'Bạn cần chọn kiểu loại của sản phẩm mà bạn cần đăng hình ảnh',
            'model_id.integer' => 'Sai dữ liệu',
            'model_id.numeric' => 'Sai dữ liệu',
            'model_id.exists' => 'Sai dữ liệu',

            'images.required' => 'Bạn cần thêm hình',
            'images.array' => 'Sai dữ liệu',

            'images.*.required' => 'Bạn cần thêm hình',
            'images.*.mimes' => 'Hình #:position của bạn cần có định dạng: png, jpg, jpeg',
            'images.*.dimensions' => 'Hình #:position của bạn cần phải đúng tỉ lệ 1:1',
            'images.*.max' => 'Hình #:position của bạn cần phải ít hơn 2Mb',




        ];
    }
}
