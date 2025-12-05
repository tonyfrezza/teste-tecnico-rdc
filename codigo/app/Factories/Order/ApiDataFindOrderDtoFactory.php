<?php

namespace App\Factories\Order;

use App\Dtos\Order\ApiDataFindOrderDto;
use Exception;

class ApiDataFindOrderDtoFactory
{
    public function create(array $data): ApiDataFindOrderDto
    {
        try {
            return new ApiDataFindOrderDto([
                'customer_name' => $data['customer_name'] ?? '',
                'status' => $data['status'] ?? '',
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
