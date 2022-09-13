<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvatarImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
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
            'avatar_file' => 'required|image|mimes:png,jpg,jpeg|max:1024'
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
            'avatar_file.required' => 'Bạn cần thêm hình',
            'avatar_file.image' => 'Tập tin bạn cần upload phải có định dạng hình',
            'avatar_file.mimes' => 'Tập tin bạn cần upload phải có định dạng .png, .jpg hoặc .jpeg',
            'avatar_file.max' => 'Kích cỡ tập tin bạn cần upload phải dưới 1MB',
        ];
    }
}
