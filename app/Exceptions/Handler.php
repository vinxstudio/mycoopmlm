<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Lang;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
        if ($this->isHttpException($e))
        {
            return $this->renderHttpException($e);
        }

        if ((bool)config('system.debug') == false) {
            if ($e instanceof QueryException) {
                return back()->with('danger', Lang::get('messages.generic_error'));
            }
        }

        if ($e instanceof NotFoundHttpException){
            return response()->view('errors.404');
        }

		if ($e instanceof TokenMismatchException){
            // Redirect to a form. Here is an example of how I handle mine
            return redirect($request->fullUrl())->with('csrf_error',"Oops! Seems you couldn't submit form for a long time. Please try again.");
        }

      //  return parent::render($request, $e);
        /*if (config('app.debug'))
        {
            return $this->renderExceptionWithWhoops($e);
        }*/

        return parent::render($request, $e);
	}

    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
}
