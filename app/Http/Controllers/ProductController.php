<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService\ProductServiceInterface;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function search(ProductSearchRequest $request): JsonResponse
    {
        $productService = app(ProductServiceInterface::class);
        $products = $productService->searchPagination($request);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
