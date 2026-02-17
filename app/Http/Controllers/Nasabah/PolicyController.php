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

        $expiredPolicies = Policy::where('user_id', $userId)
            ->where('status', 'expired')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelledPolicies = Policy::where('user_id', $userId)
            ->where('status', 'cancelled')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.policies-overview', compact(
            'activePolicies',
            'pendingPolicies',
            'expiredPolicies',
            'cancelledPolicies'
        ));
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
        $user = auth('nasabah')->user();
        $profile = $user?->nasabahProfile;
        $products = Product::where('is_active', true)->get();

        return view('frontend.nasabah.apply-policy', compact('products', 'user', 'profile'));
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
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'premium_paid' => ['required', 'numeric', 'min:0'],
        ]);

        $userId = auth('nasabah')->id() ?? auth()->id();
        $productId = $validated['product_id'];

        // Check if user already has an active policy with the same product
        $existingActivePolicy = Policy::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->first();

        if ($existingActivePolicy) {
            return back()->withErrors([
                'product_id' => 'Anda sudah memiliki polis aktif untuk produk ini. Silakan perpanjang polis yang sudah ada atau tunggu hingga polis berakhir.',
            ]);
        }

        // Check if user already has a pending policy with the same product
        $existingPendingPolicy = Policy::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('status', 'pending')
            ->first();

        if ($existingPendingPolicy) {
            return back()->withErrors([
                'product_id' => 'Anda sudah memiliki pengajuan polis menunggu persetujuan untuk produk ini.',
            ]);
        }

        // Remove category from data as it's only for validation/filtering
        $data = collect($validated)->except('category')->toArray();
        $data['end_date'] = $data['start_date']
            ? \Illuminate\Support\Carbon::parse($data['start_date'])->addYear()->toDateString()
            : $data['end_date'];

        $policy = Policy::create(array_merge($data, [
            'user_id' => $userId,
            'status' => 'pending',
        ]));

        return redirect()->route('nasabah.policies')
            ->with('success', 'Pengajuan polis berhasil dikirim menunggu persetujuan manager.')
            ->with('show_sweet_alert', true);
    }

    /**
     * Renew an expired policy
     */
    public function renew(Policy $policy)
    {
        $userId = auth('nasabah')->id() ?? auth()->id();

        // Authorization check
        if ($policy->user_id !== $userId) {
            abort(403, 'Unauthorized');
        }

        // Check if policy can be renewed
        if (!$policy->canBeRenewed()) {
            return back()->withErrors([
                'error' => 'Polis tidak dapat diperpanjang. Polis harus sudah berakhir untuk dapat diperpanjang.',
            ]);
        }

        // Check if there's already a renewal pending for this policy
        $existingRenewal = Policy::where('renewal_from_policy_id', $policy->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRenewal) {
            return back()->withErrors([
                'error' => 'Anda sudah memiliki pengajuan perpanjangan polis yang menunggu persetujuan.',
            ]);
        }

        // Create new policy as renewal
        $newStartDate = $policy->end_date->addDay();
        $newEndDate = $newStartDate->clone()->addYear();

        $renewalPolicy = Policy::create([
            'user_id' => $userId,
            'product_id' => $policy->product_id,
            'renewal_from_policy_id' => $policy->id,
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'premium_paid' => $policy->premium_paid,
            'status' => 'pending',
        ]);

        return redirect()->route('nasabah.policies')
            ->with('success', 'Pengajuan perpanjangan polis berhasil dikirim menunggu persetujuan manager.')
            ->with('show_sweet_alert', true);
    }

    /**
     * Cancel a pending policy application
     */
    public function cancel(Policy $policy)
    {
        $userId = auth('nasabah')->id() ?? auth()->id();

        // Authorization check
        if ($policy->user_id !== $userId) {
            abort(403, 'Unauthorized');
        }

        // Check if policy is pending
        if (!$policy->isPending()) {
            return back()->withErrors([
                'error' => 'Hanya polis yang masih menunggu persetujuan yang dapat dibatalkan.',
            ]);
        }

        // Update policy status to cancelled
        $policy->update([
            'status' => 'cancelled',
            'rejection_note' => 'Dibatalkan oleh nasabah',
        ]);

        return redirect()->route('nasabah.policies')
            ->with('success', 'Pengajuan polis berhasil dibatalkan.')
            ->with('show_sweet_alert', true);
    }
}
