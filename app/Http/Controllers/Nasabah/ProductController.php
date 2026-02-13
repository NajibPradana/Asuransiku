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
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get service information based on category
        $serviceInfo = $this->getServiceInfo($product->category);

        return view('frontend.nasabah.product-detail', compact('product', 'serviceInfo'));
    }

    /**
     * Get service information based on category.
     */
    private function getServiceInfo($category)
    {
        $services = [
            'kendaraan' => [
                'title' => 'Asuransi Kendaraan',
                'benefits' => [
                    'Perlindungan terhadap kecelakaan',
                    'Perlindungan terhadap pencurian',
                    'Perlindungan terhadap kerusakan akibat bencana alam',
                    'Bantuan derek 24 jam',
                    'Proses klaim yang cepat dan mudah',
                ],
            ],
            'kesehatan' => [
                'title' => 'Asuransi Kesehatan',
                'benefits' => [
                    'Cakupan rawat inap',
                    'Cakupan rawat jalan',
                    'Cakupan operasi dan pembedahan',
                    'Perlindungan kritis illness',
                    'Cashless di rumah sakit rekanan',
                ],
            ],
            'perjalanan' => [
                'title' => 'Asuransi Perjalanan',
                'benefits' => [
                    'Perlindungan kecelakaan perjalanan',
                    'Keterlambatan航班 dan行李',
                    'Pembatalan perjalanan',
                    'Perlindungan médical abroad',
                    'Bantuan darurat 24 jam',
                ],
            ],
            'jiwa' => [
                'title' => 'Asuransi Jiwa',
                'benefits' => [
                    'Manfaat meninggal dunia',
                    'Manfaat cacat tetap',
                    'Dana pendidikan untuk anak',
                    'Fleksibilitas periode perlindungan',
                    'Nilai tunai setelah masa perlindungan',
                ],
            ],
        ];

        return $services[$category] ?? null;
    }
}
