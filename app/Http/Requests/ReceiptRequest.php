<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'cash_box_id'                  => 'required|numeric:accounts,id',
            'account_id'                   => 'required|numeric:accounts,id',
            'balance'                      => 'required|numeric',
            'notes'                        => 'sometimes|nullable|string',
        ];
    }
    protected function onCreate(): array
    {
        return [
            'cash_box_id'                  => 'required|numeric:accounts,id',
            'account_id'                   => 'required|numeric:accounts,id',
            'type_id'                      => 'required|numeric:receipt_types,id',
            'balance'                      => 'required|numeric',
            'notes'                        => 'sometimes|nullable|string',
        ];
    }
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
