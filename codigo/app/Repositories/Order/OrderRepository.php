<?php

namespace App\Repositories\Order;

use App\Dtos\Order\SaveOrderDto;
use App\Models\Order\Order as OrderModel;
use Exception;
use Ramsey\Uuid\Uuid;

class OrderRepository
{
    public function __construct(
        private OrderModel $orderModel
    ) {}

    public function findById(string $id): OrderModel
    {
        try {
            return $this->orderModel->findOrFail($id);
        } catch (Exception) {
            throw new Exception('Pedido não encontrado');
        }
    }

    public function save(?OrderModel $order = null, SaveOrderDto $saveOrderDto,): OrderModel
    {
        try {
            if (empty($saveOrderDto->id)) {
                return $this->create($saveOrderDto);
            }
            throw new Exception("Atualização não implementada");
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function saveItems(OrderModel $order, SaveOrderDto $saveOrderDto)
    {
        try {
            $items = collect($saveOrderDto->items)
                ->map(fn($item) => (object) $item);

            $createItems = $items->whereNull('id');
            $updateItems = $items->whereNotNull('id');

            $order->load('items');

            $dtoIds = $updateItems->pluck('id')->map(fn($id) => (int)$id);

            $removeItems = $order->items->reject(
                fn($stored) => $dtoIds->contains((int) $stored->id)
            );

            $removeItems->each->delete();

            $createItems->each(function ($item) use ($order) {
                $order->items()->create([
                    'product_name' => $item->product_name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'total_price'  => $item->total_price,
                ]);
            });

            $updateItems->each(function ($item) use ($order) {
                $order->items()->where('id', $item->id)->update([
                    'product_name' => $item->product_name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'total_price'  => $item->total_price,
                ]);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(OrderModel $order): void
    {
        try {
            $order->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function create(SaveOrderDto $saveOrderDto): OrderModel
    {
        try {
            return $this->orderModel->create([
                'id'    =>  Uuid::uuid4()->toString(),
                'customer_name' => $saveOrderDto->customer_name,
                'status' => $saveOrderDto->status,
                'subtotal' => $saveOrderDto->subtotal,
                'discount' => $saveOrderDto->discount,
                'tax' => $saveOrderDto->tax,
                'total' => $saveOrderDto->total,
                'notes' => $saveOrderDto->note
                    ? [$saveOrderDto->note]
                    : [],
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function update(OrderModel $order, SaveOrderDto $saveOrderDto): OrderModel
    {
        try {

            if (!empty($saveOrderDto->note)) {
                $currentNotes = $order->notes ?? [];
                $order->notes = array_merge($currentNotes, [$saveOrderDto->note]);
            }

            $order->fill([
                'customer_name' => $saveOrderDto->customer_name,
                'status'        => $saveOrderDto->status,
                'subtotal'      => $saveOrderDto->subtotal,
                'discount'      => $saveOrderDto->discount,
                'tax'           => $saveOrderDto->tax,
                'total'         => $saveOrderDto->total,
            ])->save();

            return $order;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
