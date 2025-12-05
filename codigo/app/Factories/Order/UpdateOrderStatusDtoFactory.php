<?php

namespace App\Factories\Order;

use App\Dtos\Order\UpdateOrderStatusDto;
use Exception;

class UpdateOrderStatusDtoFactory
{
    public function create(array $data): UpdateOrderStatusDto
    {
        try {
            return new UpdateOrderStatusDto([
                'id'    =>  $data['id'],
                'status'    =>  $data['status'],

            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
