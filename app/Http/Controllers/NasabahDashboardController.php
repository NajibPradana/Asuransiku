<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Product;
use App\Models\Claim;
use Illuminate\Http\Request;

class NasabahDashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth('nasabah')->id() ?? auth()->id();

        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $activePolicies = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->with('product')
            ->orderBy('start_date', 'desc')
            ->get();

        $activePoliciesCount = $activePolicies->count();

        $pendingPoliciesCount = Policy::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $nextRenewalDate = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->orderBy('end_date')
            ->first()?->end_date;

        // Fetch the latest claim for the authenticated user
        $latestClaim = Claim::where('user_id', $userId)
            ->with('policy.product')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('frontend.nasabah.dashboard', [
            'pageTitle' => 'Nasabah Dashboard',
            'products' => $products,
            'activePolicies' => $activePolicies,
            'activePoliciesCount' => $activePoliciesCount,
            'pendingPoliciesCount' => $pendingPoliciesCount,
            'nextRenewalDate' => $nextRenewalDate,
            'latestClaim' => $latestClaim,
        ]);
    }
}
