<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;

use App\Dtos\Order\FindOrderDto;
use App\Dtos\PaginationDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderQueriesRepository
{
    const ORDER_BY_COLUMNS = [
        'customer_name' =>  'customer_name',
        'status' => 'status'
    ];


    public function retrieveWithFiltersAndPaginated(
        FindOrderDto $findOrderDto,
        PaginationDto $paginationDto
    ): Collection {
        $query = Order::query();

        $this->applyFiltersToQuery($query, $findOrderDto);
        $this->applyOrderingToQuery($query, $paginationDto);
        $this->applyPaginationToQuery($query, $paginationDto);

        return $query->get();
    }

    private function applyFiltersToQuery(
        Builder $query,
        FindOrderDto $findOrderDto
    ): void {
        if (!empty($findOrderDto->customer_name)) {

            //Aplica formato de filtro que aceita nomes não sequenciais
            //Exemplo de nome cadastrado: Tony Aldrin Fernandes Frezza
            //A pesquisa aceita: Tony Frezza
            $terms = collect(explode(' ', $findOrderDto->customer_name))
                ->filter()
                ->map(fn($t) => trim(strtolower($t)));

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->whereRaw("LOWER(customer_name) LIKE ?", ["%{$term}%"]);
                }
            });
        }

        if (!empty($findOrderDto->status)) {
            $query->where('status', $findOrderDto->status);
        }
    }

    private function applyOrderingToQuery(
        Builder $query,
        PaginationDto $paginationDto
    ): void {
        if (!empty($paginationDto->orderBy) && array_key_exists($paginationDto->orderBy, self::ORDER_BY_COLUMNS)) {
            $orderByColumn = self::ORDER_BY_COLUMNS[$paginationDto->orderBy];
            $orderDirection = strtolower($paginationDto->orderDirection) === 'desc' ? 'desc' : 'asc';
            $query->orderBy($orderByColumn, $orderDirection);
        }
    }

    private function applyPaginationToQuery(
        Builder $query,
        PaginationDto $paginationDto
    ): void {
        $query->skip(($paginationDto->page - 1) * $paginationDto->perPage)
            ->take($paginationDto->perPage);
    }
}
