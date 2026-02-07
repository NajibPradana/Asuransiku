<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use App\Models\Product;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display all policies (active and pending) dashboard.
     */
    public function overview()
    {
        $userId = auth('nasabah')->id() ?? auth()->id();
        $activePolicies = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingPolicies = Policy::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.policies-overview', compact('activePolicies', 'pendingPolicies'));
    }

    /**
     * Display user's pending policies.
     */
    public function pending()
    {
        $userId = auth('nasabah')->id() ?? auth()->id();
        $policies = Policy::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.pending-policies-list', compact('policies'));
    }

    /**
     * Display user's active policies.
     */
    public function index()
    {
        $userId = auth('nasabah')->id() ?? auth()->id();
        $policies = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.policies-list', compact('policies'));
    }

    /**
     * Show application form for a new policy.
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();

        return view('frontend.nasabah.apply-policy', compact('products'));
    }

    /**
     * Store a newly created policy in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string'],
            'product_id' => ['required', 'exists:products,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'premium_paid' => ['required', 'numeric', 'min:0'],
        ]);

        $userId = auth('nasabah')->id() ?? auth()->id();

        // Remove category from data as it's only for validation/filtering
        $data = collect($validated)->except('category')->toArray();

        $policy = Policy::create(array_merge($data, [
            'user_id' => $userId,
            'status' => 'pending',
        ]));

        return redirect()->route('nasabah.dashboard')
            ->with('success', 'Pengajuan polis berhasil dikirim menunggu persetujuan manager.')
            ->with('show_sweet_alert', true);
    }
}
