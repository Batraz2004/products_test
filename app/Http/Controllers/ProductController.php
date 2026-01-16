<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $categoryId = $request->input('category_id');
        $perPage    = $request->input('per_page', 15);
        $query      = $request->input('q');
        $rating     = $request->input('rating');
        $priceFrom  = $request->input('price_from', 0);
        $priceTo    = $request->input('price_to');
        $sort       = match ($request->input('sort')) {
            'price_asc'     => ['column' => 'price', 'sort_value' => 'asc'],
            'price_desc'    => ['column' => 'price', 'sort_value' => 'desc'],
            'rating_desc'   => ['column' => 'rating', 'sort_value' => 'desc'],
            'rating_asc'    => ['column' => 'rating', 'sort_value' => 'asc'],
            'newest'        => ['column' => 'crated_at', 'sort_value' => 'desc'],
            'default'       => ['column' => 'id', 'sort_value' => 'desc']
        };

        $products = Product::query()
            ->where('category_id', $categoryId)
            ->where('name', 'like', "%$query%")
            ->where('price', '>=', $priceFrom)
            ->where(function (Builder $query) use ($rating, $priceTo) {
                if (filled($priceTo)) {
                    $query = $query->where('price', '<=', $priceTo);
                }

                if (filled($rating)) {
                    $query = $query->where('rating', $rating);
                }

                return $query;
            })
            ->orderBy($sort['column'], $sort['sort_value'])
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
