<?php

namespace App\Http\Middleware;

use App\Exceptions\UninitializedUserException;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->is_first_login){
            throw new AuthenticationException(message:"Onboard your Profile first.");
        }
        return $next($request);
    }
}
