<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAllProducts(array $filters = [], int $pagination = 10);
    public function getProductById($id);

   
}
