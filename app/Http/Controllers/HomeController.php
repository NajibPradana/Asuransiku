<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home.landing');
    }

    public function services()
    {
        return view('frontend.home.services');
    }

    public function serviceDetail($category)
    {
        // Map category slug to category name
        $categoryMap = [
            'kendaraan' => 'kendaraan',
            'kesehatan' => 'kesehatan',
            'perjalanan' => 'perjalanan',
            'jiwa' => 'jiwa',
        ];

        $categoryName = $categoryMap[$category] ?? $category;
        
        // Get products for this category
        $products = Product::where('category', $categoryName)
            ->where('is_active', true)
            ->get();

        // Service information based on category
        $serviceInfo = $this->getServiceInfo($categoryName);

        return view('frontend.home.service-detail', compact('products', 'serviceInfo', 'category'));
    }

    private function getServiceInfo($category)
    {
        $services = [
            'kendaraan' => [
                'title' => 'Asuransi Kendaraan',
                'description' => 'Lindungi kendaraan Anda dari berbagai risiko dengan perlindungan komprehensif.',
                'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
                'benefits' => [
                    'Perlindungan terhadap kecelakaan',
                    'Perlindungan terhadap pencurian',
                    'Perlindungan terhadap kerusakan akibat bencana alam',
                    'Bantuan derek 24 jam',
                    'Proses klaim yang cepat dan mudah',
                ],
                'coverage' => 'Rp 50.000.000 - Rp 500.000.000',
                'premium' => 'Mulai dari Rp 500.000/tahun',
            ],
            'kesehatan' => [
                'title' => 'Asuransi Kesehatan',
                'description' => 'Dapatkan perlindungan kesehatan terbaik untuk Anda dan keluarga.',
                'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
                'benefits' => [
                    'Cakupan rawat inap',
                    'Cakupan rawat jalan',
                    'Cakupan operasi dan pembedahan',
                    'Perlindungan kritis illness',
                    'Cashless di rumah sakit rekanan',
                ],
                'coverage' => 'Rp 50.000.000 - Rp 500.000.000',
                'premium' => 'Mulai dari Rp 250.000/tahun',
            ],
            'perjalanan' => [
                'title' => 'Asuransi Perjalanan',
                'description' => 'Nikmati perjalanan tanpa khawatir dengan perlindungan menyeluruh.',
                'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
                'benefits' => [
                    'Perlindungan kecelakaan perjalanan',
                    'Keterlambatan航班 dan行李',
                    'Pembatalan perjalanan',
                    'Perlindungan médical abroad',
                    'Bantuan darurat 24 jam',
                ],
                'coverage' => 'Rp 25.000.000 - Rp 500.000.000',
                'premium' => 'Mulai dari Rp 100.000/perjalanan',
            ],
            'jiwa' => [
                'title' => 'Asuransi Jiwa',
                'description' => 'Lindungi masa depan keluarga dengan perlindungan jiwa yang terjangkau.',
                'icon' => 'M21 12c0 1.66-4 3-9 3s-9-1.34-9-3 4-9 9-9 9 6.34 9 9z M3.53 21.5c1.56 1.56 4.48 1.56 6.04 0 1.56-1.56 4.48-1.56 6.04 0 1.56 1.56 4.48 1.56 6.04 0',
                'benefits' => [
                    'Manfaat meninggal dunia',
                    'Manfaat cacat tetap',
                    'Dana pendidikan untuk anak',
                    'Fleksibilitas periode perlindungan',
                    'Nilai tunai setelah masa perlindungan',
                ],
                'coverage' => 'Rp 100.000.000 - Rp 1.000.000.000',
                'premium' => 'Mulai dari Rp 200.000/tahun',
            ],
        ];

        return $services[$category] ?? null;
    }
}
