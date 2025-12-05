<?php

namespace App\Http\Controllers\Api\Orders;

use App\Factories\Order\ApiDataDestroyOrderDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\DestroyOrderRequest;
use App\UseCases\Order\DestroyOrder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class DestroyController extends Controller
{
    public function __construct(
        private DestroyOrder $destroyOrder,
        private ApiDataDestroyOrderDtoFactory $apiDataDestroyOrderDtoFactory
    ) {}

    public function __invoke(DestroyOrderRequest $request): HttpResponse|JsonResponse
    {
        try {
            $apiDataDestroyOrderDto = $this->apiDataDestroyOrderDtoFactory->create([
                'id'    => $request->id
            ]);
            $this->destroyOrder->execute($apiDataDestroyOrderDto);

            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
