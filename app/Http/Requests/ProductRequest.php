<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $barcode
 */
class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'barcode'           => 'array|min:1',
            'barcode.*'         => 'required|string|unique:barcodes,barcode',
            'name'              => 'required|string|max:255',
            'order_limit'       => 'sometimes|nullable|numeric',
            'purchase_price'    => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'wholesale_price'   => 'sometimes|nullable|numeric',
            'half_price'        => 'sometimes|nullable|numeric',
            'unit_id'           => 'required|numeric|exists:units,id',
            'category_id'       => 'required|numeric|exists:categories,id',
            'expiry_date'       => 'sometimes|nullable|date',
        ];
    }
    protected function onCreate(): array
    {
        return [
            'barcode'           => 'array|min:1',
            'barcode.*'         => 'required|string|unique:barcodes,barcode',
            'name'              => 'required|string|max:255',
            'order_limit'       => 'sometimes|nullable|numeric',
            'purchase_price'    => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'wholesale_price'   => 'sometimes|nullable|numeric',
            'half_price'        => 'sometimes|nullable|numeric',
            'unit_id'           => 'required|numeric|exists:units,id',
            'category_id'       => 'required|numeric|exists:categories,id',
            'expiry_date'       => 'sometimes|nullable|date',
        ];
    }
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
