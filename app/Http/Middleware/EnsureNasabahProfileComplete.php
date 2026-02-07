<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNasabahProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('nasabah')->user();

        if (! $user) {
            return redirect()->route('nasabah.login');
        }

        $profile = $user->nasabahProfile;

        $requiredUserFields = [
            $user->firstname,
            $user->lastname,
            $user->email,
            $user->username,
        ];

        $requiredProfileFields = [
            $profile?->nik,
            $profile?->birth_place,
            $profile?->birth_date,
            $profile?->address,
            $profile?->occupation,
            $profile?->monthly_income,
            $profile?->assets,
        ];

        $hasAllUserFields = collect($requiredUserFields)->every(fn($value) => filled($value));
        $hasAllProfileFields = collect($requiredProfileFields)->every(fn($value) => filled($value));

        if (! $hasAllUserFields || ! $hasAllProfileFields) {
            return redirect()
                ->route('nasabah.profile')
                ->with('profile_incomplete', 'Lengkapi profil Anda terlebih dahulu sebelum mengajukan polis atau klaim.');
        }

        return $next($request);
    }
}
