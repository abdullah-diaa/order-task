<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'sku', 'status', 'price', 'weight']);
        
        $pagination = $request->get('pagination', 10);
        
        // Fetch products from the service with filters and pagination
        $products = $this->productService->getAllProducts($filters, $pagination);
        
        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

  
}