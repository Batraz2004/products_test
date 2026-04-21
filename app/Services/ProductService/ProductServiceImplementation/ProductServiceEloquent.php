<?php

namespace App\Services\ProductService\ProductServiceImplementation;

use App\DTO\ProductSearchPaginationDto;
use App\Models\Product;
use App\Services\ProductService\ProductServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductServiceEloquent implements ProductServiceInterface
{
    public function searchPagination(ProductSearchPaginationDto $dto): LengthAwarePaginator
    {
        $products = Product::query()
            ->where('category_id', $dto->categoryId)
            ->where('name', 'like', "%$dto->query%")
            ->where('price', '>=', $dto->priceFrom)
            ->where('rating', $dto->rating)
            ->where('price', '<=', $dto->priceTo)
            ->orderBy($dto->sort['column'], $dto->sort['sort_value'])
            ->paginate($dto->perPage);

            return $products;
    }
}
