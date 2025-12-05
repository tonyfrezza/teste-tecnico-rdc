<?php

namespace App\Services\Order;

class OrderCalculatorService
{
    public function getTotalPrice(array $item): float
    {
        return $item['quantity'] * $item['unit_price'];
    }

    public function getSubtotal(array $items): float
    {
        return array_reduce($items, function ($carry, $item) {
            return $carry + $item['total_price'];
        }, 0);
    }

    public function getTotal(float $subtotal, float $discount, float $tax): float
    {
        return $subtotal - $discount + $tax;
    }
}
