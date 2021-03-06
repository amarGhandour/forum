<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{

    public function show(User $user)
    {

        return view('profile.show', [
            'user' => $user,
            'threads' => $user->threads()->paginate(30),
        ]);
    }
}
