<?php namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

    protected $allowedDomains = [];

	public function handle($request, Closure $next)
	{
        $current = str_replace('http://', '', $request->url());
        $current = str_replace('https://', '', $current);
        $exp = explode('/', $current);
        $this->allowedDomains[] = $exp[0];
        $domain = (starts_with($request->root(), 'http://') or starts_with($request->root(), 'https://')) ? substr($request->root(), 7) : $request->root();

        if (!$request->secure() and in_array($domain, $this->allowedDomains) and config('system.https')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
	}

}
