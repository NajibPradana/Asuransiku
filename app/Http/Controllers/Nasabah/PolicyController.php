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
            ->whereDate('end_date', '>=', now()->toDateString())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingPolicies = Policy::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $expiredPolicies = Policy::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'expired')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'active')
                            ->whereDate('end_date', '<', now()->toDateString());
                    });
            })
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.policies-overview', compact('activePolicies', 'pendingPolicies', 'expiredPolicies'));
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
            ->whereDate('end_date', '>=', now()->toDateString())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.policies-list', compact('policies'));
    }

    /**
     * Show application form for a new policy.
     */
    public function create(Request $request)
    {
        $user = auth('nasabah')->user();
        $profile = $user?->nasabahProfile;
        $products = Product::where('is_active', true)->get();
        $userId = auth('nasabah')->id() ?? auth()->id();
        $activePolicies = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->with('product')
            ->get();
        $activeProductIds = $activePolicies->pluck('product_id')->unique()->values();
        $activeProductNames = $activePolicies
            ->pluck('product.name')
            ->filter()
            ->unique()
            ->values();
        $selectedProduct = null;
        $renewalFromPolicyId = null;
        if ($request->filled('renewal_from_policy_id')) {
            $renewalFromPolicyId = (int) $request->query('renewal_from_policy_id');
            $renewalPolicy = Policy::where('id', $renewalFromPolicyId)
                ->where('user_id', $userId)
                ->where('status', 'expired')
                ->first();
            if ($renewalPolicy) {
                $selectedProduct = $products->firstWhere('id', $renewalPolicy->product_id);
            } else {
                $renewalFromPolicyId = null;
            }
        }

        if (!$selectedProduct && $request->filled('product_id')) {
            $selectedProduct = $products->firstWhere('id', (int) $request->query('product_id'));
        }

        return view('frontend.nasabah.apply-policy', compact('products', 'user', 'profile', 'activeProductIds', 'activeProductNames', 'selectedProduct', 'renewalFromPolicyId'));
    }

    /**
     * Store a newly created policy in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string'],
            'product_id' => ['required', 'exists:products,id'],
            'renewal_from_policy_id' => ['nullable', 'integer', 'exists:policies,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'premium_paid' => ['required', 'numeric', 'min:0'],
        ]);

        $userId = auth('nasabah')->id() ?? auth()->id();
        $productName = Product::whereKey($validated['product_id'])->value('name');
        $pendingPolicy = Policy::where('user_id', $userId)
            ->where('product_id', $validated['product_id'])
            ->where('status', 'pending')
            ->exists();
        $activePolicy = Policy::where('user_id', $userId)
            ->where('product_id', $validated['product_id'])
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->exists();

        $renewalPolicy = null;
        if (!empty($validated['renewal_from_policy_id'])) {
            $renewalPolicy = Policy::where('id', $validated['renewal_from_policy_id'])
                ->where('user_id', $userId)
                ->where('status', 'expired')
                ->first();

            if (!$renewalPolicy || (int) $renewalPolicy->product_id !== (int) $validated['product_id']) {
                return back()
                    ->withInput()
                    ->with('error', 'Data perpanjangan tidak valid. Silakan ulangi dari halaman polis expired.')
                    ->with('show_sweet_alert', true);
            }
        }

        if ($pendingPolicy || $activePolicy) {
            $message = $pendingPolicy
                ? 'Pengajuan produk ' . ($productName ?: 'ini') . ' masih menunggu persetujuan. Silakan tunggu hasilnya sebelum mengajukan lagi.'
                : 'Anda masih berlangganan produk ' . ($productName ?: 'ini') . '. Anda hanya bisa mengajukan kembali setelah polis berakhir.';

            return back()
                ->withInput()
                ->with('error', $message)
                ->with('show_sweet_alert', true);
        }

        // Remove category from data as it's only for validation/filtering
        $data = collect($validated)->except('category')->toArray();
        $data['end_date'] = $data['start_date']
            ? \Illuminate\Support\Carbon::parse($data['start_date'])->addYear()->toDateString()
            : $data['end_date'];

        $status = $renewalPolicy ? 'active' : 'pending';

        $policy = Policy::create(array_merge($data, [
            'user_id' => $userId,
            'status' => $status,
            'approved_at' => $status === 'active' ? now() : null,
            'renewal_from_policy_id' => $renewalPolicy?->id,
        ]));

        if ($renewalPolicy) {
            $renewalPolicy->delete();
        }

        $successMessage = $status === 'active'
            ? 'Perpanjangan polis berhasil dan sudah aktif.'
            : 'Pengajuan polis berhasil dikirim menunggu persetujuan manager.';

        return redirect()->route('nasabah.policies')
            ->with('success', $successMessage)
            ->with('show_sweet_alert', true);
    }

    /**
     * Cancel a pending policy submission.
     */
    public function cancel(Policy $policy)
    {
        $userId = auth('nasabah')->id() ?? auth()->id();

        if ($policy->user_id !== $userId) {
            abort(403);
        }

        if ($policy->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini tidak bisa dibatalkan karena statusnya sudah berubah.');
        }

        $policy->update([
            'status' => 'cancelled',
            'rejection_note' => 'Dibatalkan oleh nasabah',
        ]);

        return back()->with('success', 'Pengajuan polis berhasil dibatalkan.');
    }
}
