<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'account_name'                   => 'required|string|unique:accounts,name',
            'sub_account_id'                 => 'required|numeric|exists:sub_accounts,id',
        ];
    }
    protected function onCreate(): array
    {
        return [
            'account_name'                   => 'required|string|unique:accounts,name',
            'sub_account_id'                 => 'required|numeric|exists:sub_accounts,id',
        ];
    }
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
