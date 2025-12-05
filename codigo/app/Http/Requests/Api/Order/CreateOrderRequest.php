<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' =>  [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u', // apenas letras (unicode) e espaços
            ],
            'discount'  =>  ['nullable', 'numeric', 'decimal:2', 'min:0'],
            'tax'   =>  ['nullable', 'numeric', 'decimal:2', 'min:0'],
            'note'  =>  ['nullable'],
            'items' =>  ['required', 'array', 'min:1'],

            'items.*.product_name'  =>  ['required', 'string', 'max:255'],
            'items.*.quantity'  =>  ['required', 'integer', 'min:1'],
            'items.*.unit_price'    =>  ['required', 'numeric', 'decimal:2', 'min:0.01'],
        ];
    }

    public function attributes()
    {
        return [
            'customer_name' =>  'Nome do cliente',
            'discount'  =>  'Desconto',
            'tax'   =>  'Imposto',
            'note'  =>  'Observações',
            'items' =>  'Itens',

            'items.*.product_name'  =>  'Nome do produto',
            'items.*.quantity'  =>  'Quantidade',
            'items.*.unit_price'    =>  'Preço unitário',
        ];
    }
}
