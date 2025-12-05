<?php

namespace App\Factories\Order;

use App\Dtos\Order\FindOrderDto;
use Exception;

class FindOrderDtoFactory
{
    public function create(array $data): FindOrderDto
    {
        try {
            return new FindOrderDto([
                'customer_name' => $data['customer_name'] ?? '',
                'status' => $data['status'] ?? '',
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
