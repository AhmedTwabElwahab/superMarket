<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $address
 */
class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'name'                  => 'required|string',
            'email'                 => 'sometimes|nullable|email',
            'number'                => 'sometimes|nullable|numeric',
            'phone'                 => 'sometimes|nullable|numeric',
            'whatsApp'              => 'sometimes|nullable|numeric',
            'address'               => 'sometimes|nullable|string',
        ];
    }
    protected function onCreate(): array
    {
        return [
            'name'                  => 'required|string',
            'email'                 => 'sometimes|nullable|email',
            'number'                => 'sometimes|nullable|numeric',
            'phone'                 => 'sometimes|nullable|numeric',
            'whatsApp'              => 'sometimes|nullable|numeric',
            'address'               => 'sometimes|nullable|string',
        ];
    }
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
