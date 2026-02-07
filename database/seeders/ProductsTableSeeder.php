<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Asuransi Kesehatan Basic',
                'description' => 'Perlindungan kesehatan dasar untuk rawat inap dan rawat jalan.',
                'base_premium' => 250000,
                'coverage_amount' => 50000000,
                'is_active' => true,
            ],
            [
                'name' => 'Asuransi Kesehatan Premium',
                'description' => 'Manfaat kesehatan lengkap dengan limit yang lebih tinggi.',
                'base_premium' => 450000,
                'coverage_amount' => 150000000,
                'is_active' => true,
            ],
            [
                'name' => 'Asuransi Perjalanan Domestik',
                'description' => 'Perlindungan perjalanan dalam negeri untuk kecelakaan dan keterlambatan.',
                'base_premium' => 100000,
                'coverage_amount' => 25000000,
                'is_active' => true,
            ],
            [
                'name' => 'Asuransi Perjalanan Internasional',
                'description' => 'Perlindungan perjalanan luar negeri dengan benefit lebih luas.',
                'base_premium' => 350000,
                'coverage_amount' => 100000000,
                'is_active' => true,
            ],
            [
                'name' => 'Asuransi Jiwa Berjangka',
                'description' => 'Perlindungan jiwa berjangka dengan premi terjangkau.',
                'base_premium' => 200000,
                'coverage_amount' => 300000000,
                'is_active' => true,
            ],
            [
                'name' => 'Asuransi Kendaraan Komprehensif',
                'description' => 'Perlindungan kendaraan untuk risiko tabrakan, banjir, dan pencurian.',
                'base_premium' => 600000,
                'coverage_amount' => 200000000,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            $slug = $this->uniqueSlug($product['name']);
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $product['name'],
                    'slug' => $slug,
                    'description' => $product['description'],
                    'base_premium' => $product['base_premium'],
                    'coverage_amount' => $product['coverage_amount'],
                    'is_active' => $product['is_active'],
                ]
            );
        }
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $suffix = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
