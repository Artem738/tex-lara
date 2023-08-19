<?php

namespace App\Http\Services;

use App\Http\DTO\ProductIndexDto;
use App\Models\Product;

class ProductApiService
{
    public function getIndexProducts(ProductIndexDto $dto)
    {
        $query = Product::query()
            ->select('products.*') // Выбираем все столбцы из таблицы "products"
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id');

        // Применяем фильтры на основе DTO
        if ($dto->getCategory()) {
            $query->where('categories.id', $dto->getCategory());
        }

        // Повторите аналогичные шаги для остальных фильтров (fabric, tone, pattern, country, purpose, lastId, prod_status).

        if ($dto->getLastId()) {
            $query->where('products.id', '>', $dto->getLastId());
        }

        // Вы можете добавить другие фильтры, если это необходимо.

        // Выполните выборку
        $result = $query->get();

        return $result;
    }
}
