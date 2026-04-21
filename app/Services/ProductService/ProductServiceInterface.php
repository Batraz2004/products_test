<?php

namespace App\Services\ProductService;

use App\DTO\ProductSearchPaginationDto;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function searchPagination(ProductSearchPaginationDto $dto): LengthAwarePaginator;
}
