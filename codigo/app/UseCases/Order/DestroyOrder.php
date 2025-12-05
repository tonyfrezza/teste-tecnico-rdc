<?php

namespace App\UseCases\Order;

use App\Dtos\Order\ApiDataDestroyOrderDto;
use App\Services\Order\OrderService;
use Exception;

class DestroyOrder
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function execute(ApiDataDestroyOrderDto $apiDataDestroyOrderDto): void
    {
        try {
            $this->orderService->destroyOrderById($apiDataDestroyOrderDto->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
