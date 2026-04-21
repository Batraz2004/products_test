<?php

namespace App\Services\ProductService\ProductServiceImplementation;

use App\Enums\ProductSearchSortEnum;
use App\Http\Requests\ProductSearchRequest;
use App\Models\Product;
use App\Services\ProductService\ProductServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductServiceEloquent implements ProductServiceInterface
{
    public function searchPagination(ProductSearchRequest $request): LengthAwarePaginator
    {
        $perPage    = $request->input('per_page', 15);
        $categoryId = $request->input('category_id');
        $query      = $request->input('q');
        $priceFrom  = $request->input('price_from', 0);
        $sort       = ProductSearchSortEnum::tryFrom($request->input('sort', 'newest'))?->sortAssoc();

        $products = Product::query()
            ->where('category_id', $categoryId)
            ->where('name', 'like', "%$query%")
            ->where('price', '>=', $priceFrom)
            ->when($request->has('rating'), function (Builder $query) use ($request) {
                $rating = $request->input('rating');
                $query  = $query->where('rating', $rating);
            })
            ->when($request->has('price_to'), function (Builder $query) use ($request) {
                $priceTo = $request->input('price_to');
                $query   = $query->where('price', '<=', $priceTo);
            })
            ->orderBy($sort['column'], $sort['sort_value'])
            ->paginate($perPage);
        
        return $products;
    }
}
