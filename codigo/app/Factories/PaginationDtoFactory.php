<?php

namespace App\Factories;

use App\Dtos\PaginationDto;
use App\Enums\OrderQueryEnum;
use Exception;

class PaginationDtoFactory
{
    const DEFAULT_PAGE = 1;
    const DEFAULT_PER_PAGE = 15;
    const DEFAULT_ORDER_DIRECTION = OrderQueryEnum::ASC->value;

    public function create(array $data): PaginationDto
    {

        try {
            if (!empty($data['order_direction']) && OrderQueryEnum::tryFrom($data['order_direction']) == null) {
                throw new Exception("Direção de ordenação inválida");
            }

            return new PaginationDto([
                'page' => $data['page'] ?? self::DEFAULT_PAGE,
                'per_page' => $data['per_page'] ?? self::DEFAULT_PER_PAGE,
                'order_by' => $data['order_by'] ?? '',
                'order_direction' => $data['order_direction'] ?? self::DEFAULT_ORDER_DIRECTION
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
