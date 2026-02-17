<?php

namespace Database\Seeders;

use App\Models\Policy;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpiredPoliciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasabahUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'nasabah');
        })->first();

        $existingProductIds = Policy::where('user_id', $nasabahUser->id)
            ->pluck('product_id')
            ->unique()
            ->values();
        $products = Product::where('is_active', true)
            ->whereNotIn('id', $existingProductIds)
            ->get();

        if (!$nasabahUser || $products->isEmpty()) {
            return;
        }

        $startDate = now()->subYears(2);

        $expiredPolicies = [
            [
                'policy_number' => 'POL-20240207001001',
                'user_id' => $nasabahUser->id,
                'product_id' => $products->first()->id,
                'start_date' => $startDate,
                'end_date' => $startDate->clone()->addYear(),
                'premium_paid' => 180000,
                'status' => 'expired',
            ],
            [
                'policy_number' => 'POL-20240207001002',
                'user_id' => $nasabahUser->id,
                'product_id' => $products->count() > 1 ? $products->get(1)->id : $products->first()->id,
                'start_date' => $startDate->clone()->addMonths(3),
                'end_date' => $startDate->clone()->addMonths(3)->addYear(),
                'premium_paid' => 210000,
                'status' => 'expired',
            ],
        ];

        foreach ($expiredPolicies as $policy) {
            Policy::firstOrCreate(
                ['policy_number' => $policy['policy_number']],
                $policy
            );
        }
    }
}
