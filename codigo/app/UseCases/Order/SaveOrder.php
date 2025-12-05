<?php

namespace App\UseCases\Order;

use App\Dtos\Order\ApiDataSaveOrderDto;
use App\Factories\Order\SaveOrderDtoFactory;
use App\Models\Order\Order;
use App\Services\Order\OrderService;
use App\Services\TransactionsDbService;
use Exception;

class SaveOrder
{
    public function __construct(
        private SaveOrderDtoFactory $saveOrderDtoFactory,
        private TransactionsDbService $transactionsDbService,
        private OrderService $orderService
    ) {}

    public function execute(ApiDataSaveOrderDto $apiDataSaveOrderDto): Order
    {
        try {
            $saveOrderDto = $this->saveOrderDtoFactory->create([
                'id' => $apiDataSaveOrderDto->id,
                'status' => $apiDataSaveOrderDto->status,
                'customer_name' => $apiDataSaveOrderDto->customer_name,
                'discount' => $apiDataSaveOrderDto->discount,
                'tax' => $apiDataSaveOrderDto->tax,
                'note' => $apiDataSaveOrderDto->note,
                'items' => $apiDataSaveOrderDto->items,
            ]);
            return $this->transactionsDbService->execute(function () use ($saveOrderDto) {
                return $this->orderService->save($saveOrderDto);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
