<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Make sure to change this if you have authorization checks
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sku' => 'required|string|unique:products,sku|max:255',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,discontinued',
            'discount_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom attributes for the validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'product name',
            'description' => 'product description',
            'sku' => 'SKU',
            'weight' => 'weight',
            'status' => 'product status',
            'discount_price' => 'discount price',
            'price' => 'price',
            'stock' => 'stock',
        ];
    }
}
