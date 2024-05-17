<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'uploadImage' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'files.*.image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'uploadImage.image' => '画像ファイルを選択してください。',
            'uploadImage.mimes' => '拡張子が（jpg,jpeg,png）の画像を選択してください。',
            'uploadImage.max' => 'サイズが2MB以下の画像を選択してください。',
            'files.*.image.image' => '画像ファイルを選択してください。',
            'files.*.image.required' => '画像ファイルを選択してください。',
            'files.*.image.mimes' => '拡張子が（jpg,jpeg,png）の画像を選択してください。',
            'files.*.image.max' => 'サイズが2MB以下の画像を選択してください。',
        ];
    }
}
