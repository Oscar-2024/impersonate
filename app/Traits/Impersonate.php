<?php

namespace App\Traits;

use App\Models\User;

trait Impersonate
{
    public static function isImpersonating(): bool
    {
        return session()->has('impersonator');
    }

    public function isImpersonatingTo(User $user): bool
    {
        return $this->impersonating_to === $user->id;
    }

    public function realUser(): User
    {
        return self::isImpersonating() ? session('impersonator') : $this;
    }

    public function canImpersonate(): bool
    {
        return $this->realUser()->can_impersonate;
    }

    public function canBeImpersonated(): bool
    {
        return $this->can_be_impersonated;
    }

    public function impersonate(User $user): bool
    {
        $realUser = $this->realUser();

        if (! $this->canImpersonate()) {
            return false;
        }

        if (! $user->canBeImpersonated()) {
            return false;
        }

        if ($realUser->isImpersonatingTo($user)) {
            return true;
        }

        session()->put('impersonator', $realUser);

        $realUser->impersonating_to = $user->id;
        $realUser->impersonated_at = now();
        $realUser->save();

        auth()->loginUsingId($user->id);

        return true;
    }

    public function leaveImpersonation(): bool
    {
        $realUser = $this->realUser();

        if (! self::isImpersonating()) {
            return false;
        }

        session()->forget('impersonator');

        auth()->login($realUser);
        auth()->user()->impersonating_to = null;
        auth()->user()->impersonated_at = null;
        auth()->user()->save();

        return true;
    }
}
