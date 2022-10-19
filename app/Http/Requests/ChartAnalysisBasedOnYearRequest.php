<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChartAnalysisBasedOnYearRequest extends FormRequest
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
            'year' => "numeric|integer|min:2022|max:2100"
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
            'year.required' => 'Sơ đồ cần thông tin năm',
            'year.numeric' => 'Sai dữ liệu',
            'year.integer' => 'Sai dữ liệu',
            'year.min' => 'Sai dữ liệu',
            'year.max' => 'Sai dữ liệu',
        ];
    }

}
