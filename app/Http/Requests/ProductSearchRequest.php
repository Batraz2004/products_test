<?php

namespace App\Http\Requests;

use App\Enums\ProductSearchSortEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductSearchRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'q'           => ['nullable'],
            'sort'        => ['string', Rule::in(ProductSearchSortEnum::cases())],
            'rating'      => ['numeric', 'min:0', 'max:5'],
            'price_from'  => ['numeric', 'min:0'],
            'price_to'    => ['numeric'],
        ];
    }
}
