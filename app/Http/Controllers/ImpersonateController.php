<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    public function impersonate(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->impersonate($user), 403);

        return redirect()->route('dashboard');
    }

    public function leave(): RedirectResponse
    {
        abort_unless(auth()->user()->leaveImpersonation(), 403);

        return redirect()->route('dashboard');
    }
}
