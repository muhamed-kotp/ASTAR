<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\AuthorizeCheck;

class IsLoginAdmin
{
    use AuthorizeCheck;
    public function handle(Request $request, Closure $next): Response
    {
       $this->authorizCheck('edit-settings');
            return $next($request);

    }
}