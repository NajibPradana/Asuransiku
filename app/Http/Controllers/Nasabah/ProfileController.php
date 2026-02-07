<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display the nasabah's profile.
     */
    public function show()
    {
        return view('frontend.nasabah.profile');
    }
}
