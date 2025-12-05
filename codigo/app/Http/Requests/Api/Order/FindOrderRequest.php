<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\Order\StatusEnum;
use App\Enums\OrderQueryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FindOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('order_direction')) {
            $this->merge([
                'order_direction' => mb_strtoupper($this->input('order_direction'))
            ]);
        }
    }

    public function rules()
    {
        return [
            'customer_name' => ['string'],
            'status' => ['string', Rule::enum(StatusEnum::class)],
            'page' => ['integer'],
            'per_page' => ['integer'],
            'order_direction' => ['string', Rule::enum(OrderQueryEnum::class)],
        ];
    }

    public function attributes()
    {
        return [
            'customer_name' => 'Nome do cliente',
            'status' => 'Situação',
            'page' => 'Página',
            'per_page' => 'Itens por página',
            'order_by' => 'Ordenar por',
            'order_direction' => 'Direção da ordenação'
        ];
    }
}
