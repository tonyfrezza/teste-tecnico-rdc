<?php

namespace App\Dtos\Order;

class ApiDataUpdateOrderStatusDto
{
    public string $id;
    public string $status;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->status = $data['status'];
    }
}
