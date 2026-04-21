<?php

namespace App\Services\ProductService;

use App\Http\Requests\ProductSearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function searchPagination(ProductSearchRequest $request): LengthAwarePaginator;
}
