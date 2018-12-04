<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
{
    public function handle($request,Closure $next){
        if (!session('administrator')){
            return redirect('login');
        }
        return $next($request);
    }
}
