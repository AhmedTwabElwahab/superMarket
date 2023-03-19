<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 */
class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function onUpdate(): array
    {
        return [
            'name'              => 'required|string|max:100'
        ];
    }
    protected function onCreate(): array
    {
        return [
            'name'              => 'required|string|max:100'
        ];
    }
    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
