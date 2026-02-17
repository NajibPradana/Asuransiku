<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all active products for nasabah.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('frontend.nasabah.products', compact('products'));
    }

    /**
     * Display product detail for nasabah.
     */
    public function show(Product $product)
    {
        return view('frontend.nasabah.product-detail', [
            'product' => $product,
            'page_type' => 'product',
            'productName' => $product->name,
            'productCategory' => $product->category,
            'productPrice' => number_format((float) $product->base_premium, 0, ',', '.'),
        ]);
    }
}
