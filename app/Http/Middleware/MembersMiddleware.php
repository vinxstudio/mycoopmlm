<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class MembersMiddleware {

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
            if ($auth->role != 'member'){
                return redirect('auth/login');
            }

            if (isEmailRequired() and $auth->details->email != null and $auth->verification_code != null){
                return redirect('auth/verify')->with('danger', Lang::get('messages.please_verify'));
            }
        }

        return $next($request);
    }

}
