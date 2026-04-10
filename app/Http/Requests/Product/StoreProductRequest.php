<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'sku' => 'required|unique:products|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:10',
            'status' => 'required|string|in:' . ProductStatus::ACTIVE->value . ',' . ProductStatus::INACTIVE->value . ',' . ProductStatus::DISCONTINUED->value,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>'الاسم مطلوب',
            'description.required' =>'الوصف مطلوب',
            'sku.required' =>'الSKU مطلوب',
            'sku.required' =>'الSKU مطلوب',
            'sku.unique' =>'الSKU مسجل بالفعل',
            'sku.max' =>'الSKU يجب أن يكون مكون من 255 حرف أو أقل',
            'price.required' =>'السعر مطلوب',
            'stock_quantity.required' =>'الكمية المتوفرة مطلوبة',
            'low_stock_threshold.integer' =>' يجب أن يكون رقمًا صحيحًا',
            'status.required' =>'الحالة مطلوبة',
            'status.in' =>'الحالة غير صالحة',
        ];
    }
}
