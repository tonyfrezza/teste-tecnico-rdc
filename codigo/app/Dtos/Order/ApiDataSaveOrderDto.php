<?php

namespace App\Dtos\Order;

class ApiDataSaveOrderDto
{
    public string $id;
    public string $status;
    public string $customer_name;
    public float $discount;
    public float $tax;
    public string $note;
    public array $items;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->status = $data['status'];
        $this->customer_name = $data['customer_name'];
        $this->discount = $data['discount'];
        $this->tax = $data['tax'];
        $this->note = $data['note'];
        $this->items = $data['items'];
    }
}
