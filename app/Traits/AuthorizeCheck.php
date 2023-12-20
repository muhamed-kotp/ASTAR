<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthorizeCheck {
    public function authorizCheck($permission)
    {

            if (!Auth::user()->can($permission)) {
                throw new \Illuminate\Auth\Access\AuthorizationException(__(' Sorry, Un Authorized, admins Only'));
            }

    }
}
