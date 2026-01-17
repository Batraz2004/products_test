<?php

namespace App\Http\Controllers;

use App\Enums\ProductSearchSortEnum;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(ProductSearchRequest $request): JsonResponse
    {
        $perPage    = $request->input('per_page', 15);
        $categoryId = $request->input('category_id');
        $query      = $request->input('q');
        $priceFrom  = $request->input('price_from', 0);

        $sort       = ProductSearchSortEnum::tryFrom($request->input('sort', 'newest'))?->sortAssoc()
            ?? ProductSearchSortEnum::Newest->sortAssoc();

        $products = Product::query()
            ->where('category_id', $categoryId)
            ->where('name', 'like', "%$query%")
            ->where('price', '>=', $priceFrom)
            ->when($request->has('rating'), function (Builder $query) use ($request) {
                $query = $query->where('rating', $request->input('rating'));
            })
            ->when($request->has('price_to'), function (Builder $query) use ($request) {
                $query = $query->where('price', '<=', $request->input('price_to'));
            })
            ->orderBy($sort['column'], $sort['sort_value'])
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
