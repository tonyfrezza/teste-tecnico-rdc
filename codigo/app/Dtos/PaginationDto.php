<?php

namespace App\Dtos;

class PaginationDto
{
    public int $page;
    public int $perPage;
    public string $orderBy;
    public string $orderDirection;

    public function __construct(array $data)
    {
        $this->page = $data['page'];
        $this->perPage = $data['per_page'];
        $this->orderBy = $data['order_by'];
        $this->orderDirection = $data['order_direction'];
    }
}
