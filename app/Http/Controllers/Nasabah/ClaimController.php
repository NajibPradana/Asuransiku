<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClaimController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('nasabah')->id();

        $activeClaims = Claim::where('user_id', $userId)
            ->whereIn('status', ['pending', 'review', 'approved', 'paid'])
            ->with(['policy.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $rejectedClaims = Claim::where('user_id', $userId)
            ->where('status', 'rejected')
            ->with(['policy.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.nasabah.claims-list', [
            'activeClaims' => $activeClaims,
            'rejectedClaims' => $rejectedClaims,
        ]);
    }

    public function create(Request $request)
    {
        $userId = Auth::guard('nasabah')->id();

        $policies = Policy::where('user_id', $userId)
            ->where('status', 'active')
            ->with('product')
            ->orderBy('start_date', 'desc')
            ->get();

        $selectedPolicyId = $request->query('policy_id');
        $selectedPolicyId = $policies->firstWhere('id', (int) $selectedPolicyId)?->id;

        return view('frontend.nasabah.claims-create', [
            'policies' => $policies,
            'selectedPolicyId' => $selectedPolicyId,
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::guard('nasabah')->id();

        $validated = $request->validate([
            'policy_id' => ['required', 'exists:policies,id'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'description' => ['required', 'string', 'max:2000'],
            'amount_claimed' => ['required', 'numeric', 'min:0'],
            'evidence_files' => ['required', 'array', 'min:1'],
            'evidence_files.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $policy = Policy::where('id', $validated['policy_id'])
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->firstOrFail();

        $claim = Claim::create([
            'policy_id' => $policy->id,
            'user_id' => $userId,
            'incident_date' => $validated['incident_date'],
            'description' => $validated['description'],
            'amount_claimed' => $validated['amount_claimed'],
            'status' => 'pending',
        ]);

        $paths = [];
        foreach ($request->file('evidence_files', []) as $file) {
            $paths[] = $file->store("claims/{$claim->claim_number}", 'public');
        }

        $claim->update([
            'evidence_files' => $paths,
            'status' => 'review',
        ]);

        return redirect()
            ->route('nasabah.claims')
            ->with('success', 'Pengajuan klaim berhasil dikirim. Tim kami akan memverifikasi dokumen Anda.')
            ->with('show_sweet_alert', true);
    }

    /**
     * Display the specified claim.
     */
    public function show(Claim $claim)
    {
        $userId = Auth::guard('nasabah')->id();

        // Authorization check
        if ($claim->user_id !== $userId) {
            abort(403);
        }

        $claim->load('policy.product', 'approvedBy');

        return view('frontend.nasabah.claim-detail', compact('claim'));
    }
}
