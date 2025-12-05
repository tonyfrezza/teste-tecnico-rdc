<?php

namespace App\UseCases\Order;

use App\Dtos\Order\ApiDataUpdateOrderStatusDto;
use App\Factories\Order\UpdateOrderStatusDtoFactory;
use App\Models\Order\Order;
use App\Services\Order\OrderService;
use App\Services\TransactionsDbService;
use Exception;

class UpdateOrderStatus
{
    public function __construct(
        private UpdateOrderStatusDtoFactory $updateOrderStatusDtoFactory,
        private TransactionsDbService $transactionsDbService,
        private OrderService $orderService
    ) {}

    public function execute(ApiDataUpdateOrderStatusDto $apiDataUpdateOrderStatusDto): Order
    {
        try {
            $updateOrderStatusDto = $this->updateOrderStatusDtoFactory->create([
                'id' => $apiDataUpdateOrderStatusDto->id,
                'status' => $apiDataUpdateOrderStatusDto->status,

            ]);
            return $this->transactionsDbService->execute(function () use ($updateOrderStatusDto) {
                return $this->orderService->updateOrderStatus($updateOrderStatusDto);
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
