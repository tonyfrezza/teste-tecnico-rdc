<?php

namespace App\Factories\Order;

use App\Dtos\Order\SaveOrderDto;
use App\Enums\Order\StatusEnum;
use App\Services\Order\OrderCalculatorService;
use Exception;

class SaveOrderDtoFactory
{
    public function __construct(
        private OrderCalculatorService $orderCalculatorService
    ) {}

    public function create(array $data): SaveOrderDto
    {
        try {
            $data['items'] = array_map(function ($item) {
                $item['total_price'] = $this->orderCalculatorService->getTotalPrice($item);
                return $item;
            }, $data['items']);

            $subtotal = $this->orderCalculatorService->getSubtotal($data['items']);
            $total = $this->orderCalculatorService->getTotal(
                $subtotal,
                ($data['discount'] ?? 0),
                $data['tax'] ?? 0
            );

            if ($data['discount'] > $subtotal) {
                throw new Exception("Desconto não pode ser maior que o subtotal.");
            }

            return new SaveOrderDto([
                'id'    =>  $data['id'] ?? '',
                'status'    =>  $data['status'] ?? StatusEnum::DRAFT->value,
                'customer_name' =>  mb_strtoupper(trim($data['customer_name'])),
                'discount'  =>  isset($data['discount']) ? $data['discount'] : 0,
                'tax'   =>  isset($data['tax']) ? $data['tax'] : 0,
                'subtotal'  =>  $subtotal,
                'total' => $total,
                'note'  =>  $data['note'] ?? '',
                'items' => $data['items'],
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
