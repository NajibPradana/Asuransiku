<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Product;

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
}
