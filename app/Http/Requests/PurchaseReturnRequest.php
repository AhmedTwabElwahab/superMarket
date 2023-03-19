<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $product_id_new_
 */
class PurchaseReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'supplier_id'                => 'required|numeric|exists:suppliers,id',
            'payment_type_id'            => 'required|numeric|exists:payment_types,id',
            'product_id_new_'            => 'array|min:1',
            'product_id_new_.*'          => 'required|numeric',
            'quantity_new_'              => 'array|min:1',
            'quantity_new_.*'            => 'required|numeric',
            'purchase_price_new_'            => 'array|min:1',
            'purchase_price_new_.*'          => 'required|numeric',
            'details_id'                 => 'required|array|min:1',
            'details_id.*'               => 'required|numeric',
            'product_id'                 => 'array|min:1',
            'product_id.*'               => 'required|numeric',
            'total_bill'                 => 'required|numeric',
            'notes'                      => 'sometimes|nullable|string',
        ];
    }
    protected function onCreate(): array
    {
        return [
            'supplier_id'                => 'required|numeric|exists:suppliers,id',
            'payment_type_id'            => 'required|numeric|exists:payment_types,id',
            'product_id_new_'            => 'required|array|min:1',
            'product_id_new_.*'          => 'required|numeric',
            'quantity_new_'              => 'required|array|min:1',
            'quantity_new_.*'            => 'required|numeric',
            'purchase_price_new_'        => 'required|array|min:1',
            'purchase_price_new_.*'      => 'required|numeric',
            'total_bill'                 => 'required|numeric',
            'notes'                      => 'sometimes|nullable|string',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
