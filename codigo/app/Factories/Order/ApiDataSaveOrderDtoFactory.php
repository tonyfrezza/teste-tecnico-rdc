<?php

namespace App\Factories\Order;

use App\Dtos\Order\ApiDataSaveOrderDto;
use Exception;

class ApiDataSaveOrderDtoFactory
{
    public function create(array $data): ApiDataSaveOrderDto
    {
        try {
            return new ApiDataSaveOrderDto([
                'id'    =>  $data['id'] ?? '',
                'status'    =>  $data['status'] ?? '',
                'customer_name' =>  $data['customer_name'],
                'discount'  =>  isset($data['discount']) ? (float) $data['discount'] : 0,
                'tax'   =>  isset($data['tax']) ? (float) $data['tax'] : 0,
                'note'  =>  $data['note'] ?? '',
                'items' =>  $data['items'],
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
