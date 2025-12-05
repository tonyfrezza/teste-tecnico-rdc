<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Factories\Order\ApiDataRetrieveOrderDtoFactory;
use App\Http\Requests\Api\Order\RetrieveOrderRequest;
use App\UseCases\Order\RetrieveOrder;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct(
        private RetrieveOrder $retrieveOrder,
        private ApiDataRetrieveOrderDtoFactory $apiDataRetrieveOrderDtoFactory
    ) {}

    public function __invoke(RetrieveOrderRequest $request): JsonResponse
    {
        try {
            $apiDataRetrieveOrderDto = $this->apiDataRetrieveOrderDtoFactory->create([
                'id'    => $request->id
            ]);
            $order = $this->retrieveOrder->execute($apiDataRetrieveOrderDto);
            return response()->json($order, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
