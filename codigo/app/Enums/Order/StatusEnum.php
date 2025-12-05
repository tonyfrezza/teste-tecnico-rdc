<?php

namespace App\Enums\Order;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function name(): string
    {
        return match ($this) {
            self::DRAFT =>  'RASCUNHO',
            self::PENDING   =>  'PENDENTE',
            self::PAID  =>  'PAGO',
            self::CANCELLED =>  'CANCELADO',
        };
    }

    public function canTransitionTo(StatusEnum $newStatus): bool
    {
        return in_array($newStatus, $this->allowedTransitions(), true);
    }

    private function allowedTransitions(): array
    {
        return match ($this) {
            self::DRAFT =>  [self::PENDING],
            self::PENDING   =>  [self::PAID, self::CANCELLED],
            self::PAID  =>  [],
            self::CANCELLED =>  [],
        };
    }
}
