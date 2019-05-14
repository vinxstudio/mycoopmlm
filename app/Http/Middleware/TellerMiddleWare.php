<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TellerMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        if (!Auth::check()){
            return redirect('auth/login');
        } else {
            $auth = Auth::user();
            if ($auth->role != 'teller'){
                return redirect('auth/login');
            }
        }
		return $next($request);
	}

}
