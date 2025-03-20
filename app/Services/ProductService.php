<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    // this is Constructor to inject the product repository interface
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository; 
    }

    public function getAllProducts($filters = [], $pagination = 10)
    {
        return $this->productRepository->getAllProducts($filters, $pagination);
    }
    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id); 
    }

  

    
   
}
