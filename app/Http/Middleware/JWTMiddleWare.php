<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

use Illuminate\Http\Request;

class JWTMiddleWare
{
  
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
