<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;

final class TransactionsDbService
{
    public function execute(Closure $callback): mixed
    {
        return DB::transaction(function () use ($callback) {
            return $callback();
        });
    }
}
