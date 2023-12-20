<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGuest
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){

            return $next($request);
        }
        throw new \Illuminate\Auth\Access\AuthorizationException(__(' Sorry,You have To logout First'));
    }
}