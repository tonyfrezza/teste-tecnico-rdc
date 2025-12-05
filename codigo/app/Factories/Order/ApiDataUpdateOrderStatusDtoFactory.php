<?php

namespace App\Factories\Order;

use App\Dtos\Order\ApiDataUpdateOrderStatusDto;
use Exception;

class ApiDataUpdateOrderStatusDtoFactory
{
    public function create(array $data): ApiDataUpdateOrderStatusDto
    {
        try {
            return new ApiDataUpdateOrderStatusDto([
                'id'    =>  $data['id'] ?? '',
                'status'    =>  $data['status'] ?? '',
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
