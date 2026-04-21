<?php

namespace App\Http\Controllers;

use App\DTO\ProductSearchPaginationDto;
use App\Enums\ProductSearchSortEnum;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService\ProductServiceInterface;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function searchPagination(ProductSearchRequest $request): JsonResponse
    {
        $productService = app(ProductServiceInterface::class);

        $dto = new ProductSearchPaginationDto(
            categoryId: $request->input('category_id'),
            query: $request->input('q'),
            sort: ProductSearchSortEnum::tryFrom($request->input('sort', 'newest'))?->sortAssoc(),
            rating: $request->has('rating') ? (float)$request->input('rating') : null,
            priceFrom: $request->has('price_from') ? (float)$request->input('price_from') : null,
            priceTo: $request->has('price_to') ? (float)$request->input('price_to') : null,
            perPage: (int)$request->input('per_page', 15),
        );

        $products = $productService->searchPagination($dto);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
