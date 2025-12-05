<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Factories\Order\ApiDataUpdateOrderStatusDtoFactory;
use App\Http\Requests\Api\Order\UpdateOrderStatusRequest;
use App\UseCases\Order\UpdateOrderStatus;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateStatusController extends Controller
{
    public function __construct(
        private ApiDataUpdateOrderStatusDtoFactory $apiDataUpdateOrderStatusDtoFactory,
        private UpdateOrderStatus $updateOrderStatus
    ) {}

    public function __invoke(UpdateOrderStatusRequest $request): JsonResponse
    {
        try {
            $apiDataUpdateOrderStatusDto = $this->apiDataUpdateOrderStatusDtoFactory->create($this->getRequestData($request));
            $order = $this->updateOrderStatus->execute($apiDataUpdateOrderStatusDto);
            return response()->json($order, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getRequestData(UpdateOrderStatusRequest $request): array
    {
        return $request->only([
            'id',
            'status',
            'customer_name',
            'discount',
            'tax',
            'note',
            'items',
        ]);
    }
}
