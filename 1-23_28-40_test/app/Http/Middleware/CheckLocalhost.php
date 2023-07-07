<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLocalhost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
	 public function handle(Request $request, Closure $next): Response
    {
		 //if($request->ip() == '127.0.0.1') return $next($request); //пропуск запросу по определенному IP	
		if ($request->input("key") == 12345) {
			return $next($request);
		}else{
			abort(404);
		}
    }
}
