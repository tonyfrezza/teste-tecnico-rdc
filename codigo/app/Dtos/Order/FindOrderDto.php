<?php

namespace App\Dtos\Order;

class FindOrderDto
{
    public string $customer_name;
    public string $status;

    public function __construct(array $data)
    {
        $this->customer_name = $data['customer_name'];
        $this->status = $data['status'];
    }
}
