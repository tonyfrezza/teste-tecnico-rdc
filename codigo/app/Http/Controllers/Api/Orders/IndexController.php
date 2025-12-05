<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Factories\Order\ApiDataFindOrderDtoFactory;
use App\Factories\PaginationDtoFactory;
use App\Http\Requests\Api\Order\FindOrderRequest;
use App\UseCases\Order\FindOrders;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function __construct(
        private FindOrders $findOrders,
        private ApiDataFindOrderDtoFactory $apiDataFindOrderDtoFactory,
        private PaginationDtoFactory $paginationDtoFactory
    ) {}

    public function __invoke(FindOrderRequest $request): JsonResponse
    {
        try {
            $apiDataFindOrderDto = $this->apiDataFindOrderDtoFactory->create($this->getRequestDataFilters($request));
            $paginationDto = $this->paginationDtoFactory->create($this->getRequestPagination($request));
            $orders = $this->findOrders->execute(
                apiDataFindOrderDto: $apiDataFindOrderDto,
                paginationDto: $paginationDto
            );
            return response()->json($orders, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getRequestDataFilters(FindOrderRequest $request): array
    {
        return $request->only([
            'customer_name',
            'status',
            'page',
            'per_page'
        ]);
    }

    private function getRequestPagination(FindOrderRequest $request): array
    {
        return $request->only([
            'page',
            'per_page',
            'order_by',
            'order_direction'
        ]);
    }
}
