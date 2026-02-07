<?php

namespace Database\Seeders;

use App\Models\Policy;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the nasabah user and active products
        $nasabahUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'nasabah');
        })->first();

        $products = Product::where('is_active', true)->get();

        if (!$nasabahUser || $products->isEmpty()) {
            return;
        }

        // Create sample policies for the nasabah user
        $startDate = now()->subMonths(6);
        
        $policies = [
            [
                'policy_number' => 'POL-20260207001001',
                'user_id' => $nasabahUser->id,
                'product_id' => $products->first()->id,
                'start_date' => $startDate,
                'end_date' => $startDate->clone()->addYear(),
                'premium_paid' => 150000,
                'status' => 'active',
            ],
            [
                'policy_number' => 'POL-20260207001002',
                'user_id' => $nasabahUser->id,
                'product_id' => $products->count() > 1 ? $products->get(1)->id : $products->first()->id,
                'start_date' => $startDate->clone()->addMonth(),
                'end_date' => $startDate->clone()->addMonth()->addYear(),
                'premium_paid' => 200000,
                'status' => 'active',
            ],
            [
                'policy_number' => 'POL-20260207001003',
                'user_id' => $nasabahUser->id,
                'product_id' => $products->count() > 2 ? $products->get(2)->id : $products->first()->id,
                'start_date' => $startDate->clone()->addMonths(2),
                'end_date' => $startDate->clone()->addMonths(2)->addYear(),
                'premium_paid' => 175000,
                'status' => 'pending',
            ],
        ];

        foreach ($policies as $policy) {
            Policy::firstOrCreate(
                ['policy_number' => $policy['policy_number']],
                $policy
            );
        }
    }
}
