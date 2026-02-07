<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NasabahDashboardController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('frontend.nasabah.dashboard', [
            'pageTitle' => 'Nasabah Dashboard',
            'products' => $products,
        ]);
    }
}
