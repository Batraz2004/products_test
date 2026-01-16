<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $categoryId = $request->input('category_id');

        if (!Category::query()->where('id', $categoryId)->exists()) {
            abort(404);
        }

        $perPage    = $request->input('per_page', 15);
        $query      = $request->input('q');
        $rating    = $request->input('rating');
        $priceFrom  = $request->input('price_from', 0);
        $priceTo    = $request->input('price_to');

        $products = Product::query()
            ->where('category_id', $categoryId)
            ->where('name', 'like', "%$query%")
            ->where(function (Builder $query) use ($rating, $priceFrom, $priceTo) {
                $query = $query->where('price', '>=', $priceFrom);
                if (filled($priceTo)) {
                    $query = $query->where('price', '<=', $priceTo);
                }
                if (filled($rating)) {
                    $query = $query->where('rating', $rating);
                }
                return $query;
            })
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products)->resource,
        ], 200);
    }
}
