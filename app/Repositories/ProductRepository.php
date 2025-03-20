<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
   
    public function getAllProducts(array $filters = [], int $pagination = 10)
    {
        // applying filtering for api
        $query = Product::query();

        if (isset($filters['name']) && $filters['name']) {
            $query->where('name', 'like', "%" . $filters['name'] . "%");
        }

        if (isset($filters['sku']) && $filters['sku']) {
            $query->where('sku', 'like', "%" . $filters['sku'] . "%");
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['price']) && $filters['price']) {
            $query->where('price', $filters['price']);
        }

        if (isset($filters['weight']) && $filters['weight']) {
            $query->where('weight', $filters['weight']);
        }

        return $query->paginate($pagination);
    }
   
    public function getProductById($id)
    {
        return Product::find($id);
    }

    
    
}
