<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['string', 'required', 'max:50'],
            'information' => ['string', 'required', 'max:1000'],
            'price' => ['integer', 'required', 'min:0'],
            'sortOrder' => ['integer', 'nullable'],
            'quantity' => ['integer', 'required', 'between:0,99'],
            'shopId' => ['integer', 'required', 'exists:shops,id'],
            'secondaryId' => ['integer', 'required', 'exists:secondary_categories,id'],
            'image1' => ['nullable', 'exists:images,id'],
            'image2' => ['nullable', 'exists:images,id'],
            'image3' => ['nullable', 'exists:images,id'],
            'image4' => ['nullable', 'exists:images,id'],
            'isSelling' => ['required', 'boolean'],
        ];
    }
}
