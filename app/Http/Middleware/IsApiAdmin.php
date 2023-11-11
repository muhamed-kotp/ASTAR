<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsApiAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

            if($request->has('token'))
            {
                if ($request->token !== null)
                {
                    $user = User::where('token',$request->token)->first();
                    if($user !== null)
                    {
                        if($user->Is_admin ==1){
                            return $next($request);
                        }
                        else{
                            $error = 'Sorry This for admin only ';
                            return response()->json($error);
                        }

                    }else{
                        $error = 'Incorrect token ';
                        return response()->json($error);
                    }
                } else{
                    $error = 'Token is empty ';
                    return response()->json($error);
                 }
            } else{
                $error = 'Token is not exists ';
                return response()->json($error);
        }
    }
    }