<?php namespace App\Exceptions;

use Auth;
use Exception;
use Mail;
use URL;
use Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
		if (!config('app.debug') && !$e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
			
			$data = [
				'subject' => $e->getMessage(),
				'line' => $e->getLine(),
				'file' => $e->getFile(),
				'trace' => $e->getTrace(),
				'user' => Auth::guest() ? 'an unknown user' : Auth::user()->name,
				'url' => URL::current(),
				'previous' => URL::previous(),
			];
			
			Mail::send('emails.error', $data, function($message) {
			    $message->to('josh@left-right.co', 'Josh Reisner')->subject('HVWC Error');
			});
			
		}

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
		if (config('app.debug')) return $this->renderExceptionWithWhoops($e);

		return parent::render($request, $e);
	}

    /**
     * Render an exception using Whoops.
     * 
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }

}
