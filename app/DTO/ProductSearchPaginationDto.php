<?php

namespace App\DTO;

use App\Enums\ProductSearchSortEnum;

readonly class ProductSearchPaginationDto
{
    public function __construct(
        public int $categoryId,
        public ?string $query = null,
        public ?array $sort = null,
        public ?float $rating = null,
        public ?float $priceFrom = null,
        public ?float $priceTo = null,
        public int $perPage = 15,
    ) {}
}
