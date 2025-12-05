<?php

namespace App\Enums;

enum OrderQueryEnum: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';

    public function name(): string
    {
        return match ($this) {
            self::ASC => 'CRESCENTE',
            self::DESC => 'DECRESCENTE',
        };
    }
}
