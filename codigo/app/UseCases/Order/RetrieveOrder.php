<?php

namespace App\UseCases\Order;

use App\Dtos\Order\ApiDataRetrieveOrderDto;
use App\Models\Order\Order;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Support\Facades\Cache;

class RetrieveOrder
{

    public function __construct(
        private OrderService $orderService
    ) {}

    public function execute(ApiDataRetrieveOrderDto $apiDataRetrieveOrderDto): Order
    {
        try {
            $cacheKey = config('system.order.cache_prefix') . $apiDataRetrieveOrderDto->id;
            return Cache::remember(
                key: $cacheKey,
                ttl: now()->addMinutes(config('system.order.cache_ttl_minutes')),
                callback: function () use ($apiDataRetrieveOrderDto) {
                    return $this->orderService->retrieveOrderById($apiDataRetrieveOrderDto->id);
                }
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
