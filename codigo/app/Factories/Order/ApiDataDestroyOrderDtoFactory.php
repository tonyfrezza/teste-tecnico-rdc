<?php

namespace App\Factories\Order;

use App\Dtos\Order\ApiDataDestroyOrderDto;
use Exception;

class ApiDataDestroyOrderDtoFactory
{
    public function create(array $data): ApiDataDestroyOrderDto
    {
        try {
            return new ApiDataDestroyOrderDto([
                'id'    =>  $data['id'],

            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
