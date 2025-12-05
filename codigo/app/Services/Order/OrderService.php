<?php

namespace App\Services\Order;

use App\Dtos\Order\FindOrderDto;
use App\Dtos\Order\SaveOrderDto;
use App\Dtos\Order\UpdateOrderStatusDto;
use App\Dtos\PaginationDto;
use App\Enums\Order\StatusEnum;
use App\Models\Order\Order;
use App\Repositories\Order\OrderQueriesRepository;
use App\Repositories\Order\OrderRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderQueriesRepository $orderQueriesRepository
    ) {}

    public function retrieveOrderById(string $id): Order
    {
        $order =  $this->orderRepository->findById($id);
        $order->load('items');
        return $order;
    }

    public function retrieveWithFiltersAndPaginated(
        FindOrderDto $findOrderDto,
        PaginationDto $paginationDto
    ): Collection {
        return $this->orderQueriesRepository->retrieveWithFiltersAndPaginated(
            findOrderDto: $findOrderDto,
            paginationDto: $paginationDto
        );
    }

    public function save(SaveOrderDto $saveOrderDto): Order
    {
        try {
            $order = $this->orderRepository->save(
                saveOrderDto: $saveOrderDto
            );
            $this->orderRepository->saveItems($order, $saveOrderDto);
            return $order;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateOrderStatus(UpdateOrderStatusDto $updateOrderStatusDto): Order
    {
        $order = $this->orderRepository->findById($updateOrderStatusDto->id);
        $this->validateStatusWorkflow($order, $updateOrderStatusDto);

        $order->fill([
            'status'    => $updateOrderStatusDto->status,
        ])->save();

        Cache::forget(config('system.order.cache_prefix') . $order->id);

        return $order;
    }

    public function destroyOrderById(string $id): void
    {
        $order = $this->orderRepository->findById($id);
        $this->orderRepository->delete($order);
        Cache::forget(config('system.order.cache_prefix') . $id);
    }

    private function validateStatusWorkflow(Order $order, UpdateOrderStatusDto $updateOrderStatusDto): void
    {
        $newStatus = StatusEnum::from($updateOrderStatusDto->status);
        if ($order->status == $newStatus) {
            return;
        }

        if (!$order->status->canTransitionTo($newStatus)) {
            throw new \DomainException(
                "Transição de status inválida: {$order->status->name()} para {$newStatus->name()}"
            );
        }
    }
}
