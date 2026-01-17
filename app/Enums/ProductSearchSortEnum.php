<?php

namespace App\Enums;


enum ProductSearchSortEnum: string
{
    case PriceAsc   = 'price_asc';
    case PriceDesc  = 'price_desc';
    case RatingDesc = 'rating_desc';
    case RatingAsc  = 'rating_asc';
    case Newest     = 'newest';

    public function sortAssoc(): array
    {
        return match ($this) {
            self::PriceAsc      => ['column' => 'price',    'sort_value' => 'asc'],
            self::PriceDesc     => ['column' => 'price',    'sort_value' => 'desc'],
            self::RatingDesc    => ['column' => 'rating',   'sort_value' => 'desc'],
            self::RatingAsc     => ['column' => 'rating',   'sort_value' => 'asc'],
            self::Newest        => ['column' => 'created_at', 'sort_value' => 'desc'],
            'default'           => ['column' => 'id',       'sort_value' => 'desc']
        };
    }
}
