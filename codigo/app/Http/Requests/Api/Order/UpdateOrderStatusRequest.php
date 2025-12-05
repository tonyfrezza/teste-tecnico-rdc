<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\Order\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
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

        if ($this->has('status')) {
            $this->merge([
                'status' => mb_strtolower($this->input('status'))
            ]);
        }
    }


    public function rules()
    {
        return [
            'id' => ['required', 'uuid'],
            'status' => ['required', 'string', Rule::enum(StatusEnum::class)],
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Código',
            'status' => 'Situação',
        ];
    }
}
