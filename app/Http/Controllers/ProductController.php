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
            rating: $request->input('rating'),
            priceFrom: $request->input('price_from', 0),
            priceTo: $request->input('price_to'),
            perPage: (int)$request->input('per_page', 15),
        );

        $products = $productService->searchPagination($dto);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
