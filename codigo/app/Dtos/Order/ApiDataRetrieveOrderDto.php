<?php

namespace App\Dtos\Order;

class ApiDataRetrieveOrderDto
{
    public string $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }
}
