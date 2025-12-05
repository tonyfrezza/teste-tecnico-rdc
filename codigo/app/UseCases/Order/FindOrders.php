<?php

namespace App\UseCases\Order;

use App\Dtos\Order\ApiDataFindOrderDto;
use App\Dtos\PaginationDto;
use App\Factories\Order\FindOrderDtoFactory;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FindOrders
{
    public function __construct(
        private OrderService $orderService,
        private FindOrderDtoFactory $findOrderDtoFactory
    ) {}

    public function execute(
        ApiDataFindOrderDto $apiDataFindOrderDto,
        PaginationDto $paginationDto
    ): Collection {

        try {
            $findOrderDto = $this->findOrderDtoFactory->create([
                'customer_name' => $apiDataFindOrderDto->customer_name,
                'status' => $apiDataFindOrderDto->status,
            ]);

            return $this->orderService->retrieveWithFiltersAndPaginated($findOrderDto, $paginationDto);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
