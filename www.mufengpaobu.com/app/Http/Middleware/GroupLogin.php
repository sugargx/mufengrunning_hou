<?php



namespace App\Http\Middleware;



use Closure;





class GroupLogin

{

    public function handle($request,Closure $next){


        if (!session('captain')){

            return redirect('login');

        }

        return $next($request);

    }

}

