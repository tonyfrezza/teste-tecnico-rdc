<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Factories\Order\ApiDataSaveOrderDtoFactory;
use App\UseCases\Order\SaveOrder;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller
{
    public function __construct(
        private ApiDataSaveOrderDtoFactory $apiDataSaveOrderDtoFactory,
        private SaveOrder $saveOrder
    ) {}

    public function __invoke(CreateOrderRequest $request): JsonResponse
    {
        try {
            $apiDataSaveOrderDto = $this->apiDataSaveOrderDtoFactory->create($this->getRequestData($request));
            $order = $this->saveOrder->execute($apiDataSaveOrderDto);
            return response()->json($order, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getRequestData(CreateOrderRequest $request): array
    {
        return $request->only([
            'customer_name',
            'discount',
            'tax',
            'note',
            'items',
        ]);
    }
}
