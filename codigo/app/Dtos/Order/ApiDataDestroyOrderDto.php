<?php

namespace App\Dtos\Order;

class ApiDataDestroyOrderDto
{
    public string $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }
}
