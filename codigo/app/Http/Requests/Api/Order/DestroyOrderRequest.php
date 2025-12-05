<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class DestroyOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }


    public function rules()
    {
        return [
            'id' => ['required', 'uuid'],
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Código',
        ];
    }
}
