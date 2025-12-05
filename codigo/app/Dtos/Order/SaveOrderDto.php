<?php

namespace App\Dtos\Order;

class SaveOrderDto
{
    public string $id;
    public string $customer_name;
    public string $status;
    public float $subtotal;
    public float $discount;
    public float $tax;
    public float $total;
    public string $notes;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->customer_name = $data['customer_name'];
        $this->status = $data['status'];
        $this->subtotal = $data['subtotal'];
        $this->discount = $data['discount'];
        $this->tax = $data['tax'];
        $this->total = $data['total'];
        $this->note = $data['note'];
        $this->items = $data['items'];
    }
}
