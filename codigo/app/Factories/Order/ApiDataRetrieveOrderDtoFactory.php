<?php

namespace App\Factories\Order;

use App\Dtos\Order\ApiDataRetrieveOrderDto;
use Exception;

class ApiDataRetrieveOrderDtoFactory
{
    public function create(array $data): ApiDataRetrieveOrderDto
    {
        try {
            return new ApiDataRetrieveOrderDto([
                'id'    =>  $data['id'],

            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
