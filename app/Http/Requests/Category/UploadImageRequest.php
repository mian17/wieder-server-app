<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
            'img_file' => 'required|image|mimes:png,jpg,jpeg|max:2048',
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
            'img_file.required' => 'Bạn cần nhập hình',
            'img_file.image' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'img_file.mimes' => 'Bạn cần thêm hình với kiểu dữ liệu: png, jpg, jpeg',
            'img_file.max' => 'Kích cỡ hình cần dưới 2MB',
        ];
    }
}
