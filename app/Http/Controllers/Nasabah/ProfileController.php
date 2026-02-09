<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\NasabahProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the nasabah's profile.
     */
    public function show()
    {
        $user = Auth::guard('nasabah')->user();
        $profile = $user?->nasabahProfile;

        $options = $this->getProfileOptions();

        return view('frontend.nasabah.profile', [
            'user' => $user,
            'profile' => $profile,
            'occupationOptions' => $options['occupation'],
            'incomeOptions' => $options['income'],
            'assetOptions' => $options['assets'],
        ]);
    }

    /**
     * Update the nasabah's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('nasabah')->user();
        $options = $this->getProfileOptions();

        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'nik' => ['required', 'digits:16', 'unique:nasabah_profiles,nik,' . ($user?->nasabahProfile?->id ?? 'NULL')],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:' . now()->subYears(17)->toDateString()],
            'address' => ['required', 'string', 'max:2000'],
            'occupation' => ['required', 'string', 'in:' . implode(',', array_keys($options['occupation']))],
            'monthly_income' => ['required', 'string', 'in:' . implode(',', array_keys($options['income']))],
            'assets' => ['required', 'string', 'in:' . implode(',', array_keys($options['assets']))],
        ], [
            'birth_date.before_or_equal' => 'Tanggal lahir harus minimal 17 tahun yang lalu.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
            'username.unique' => 'Username sudah digunakan.',
            'firstname.required' => 'Nama depan wajib diisi.',
            'lastname.required' => 'Nama belakang wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'occupation.required' => 'Pekerjaan wajib dipilih.',
            'monthly_income.required' => 'Gaji per bulan wajib dipilih.',
            'assets.required' => 'Aset wajib dipilih.',
        ]);

        $emailChanged = $validated['email'] !== $user->email;

        $user->update([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
        ]);

        NasabahProfile::updateOrCreate(
            ['user_id' => $user->id],
            collect($validated)->except(['firstname', 'lastname', 'email', 'username'])->toArray()
        );

        return redirect()
            ->route('nasabah.profile')
            ->with('success', 'Profil nasabah berhasil diperbarui.');
    }

    private function getProfileOptions(): array
    {
        return [
            'occupation' => [
                'pelajar' => 'Pelajar / Mahasiswa',
                'karyawan' => 'Karyawan',
                'wiraswasta' => 'Wiraswasta',
                'profesional' => 'Profesional',
                'pns' => 'PNS / ASN',
                'irt' => 'Ibu Rumah Tangga',
                'lainnya' => 'Lainnya',
            ],
            'income' => [
                'lt_3jt' => '< Rp 3.000.000',
                '3_6jt' => 'Rp 3.000.000 - 6.000.000',
                '6_10jt' => 'Rp 6.000.000 - 10.000.000',
                '10_20jt' => 'Rp 10.000.000 - 20.000.000',
                'gt_20jt' => '> Rp 20.000.000',
            ],
            'assets' => [
                'lt_50jt' => '< Rp 50.000.000',
                '50_200jt' => 'Rp 50.000.000 - 200.000.000',
                '200_500jt' => 'Rp 200.000.000 - 500.000.000',
                '500_1m' => 'Rp 500.000.000 - 1.000.000.000',
                'gt_1m' => '> Rp 1.000.000.000',
            ],
        ];
    }
}
