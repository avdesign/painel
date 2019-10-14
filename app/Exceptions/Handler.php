<?php

namespace AVDPainel\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Essas informações serão incluídas na mensagem de log de todas as exceções
     *
     * @return array
     */
    protected function context()
    {
        return array_merge(parent::context(), [
            'foo' => 'bar',
        ]);
    }

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        $e = $this->prepareException($exception);
        $code = $e->getCode();
        $message = $e->getMessage();
        $previous = $e->getPrevious();
        $traces = $e->getTrace();
        $redirect = route('login');
        $url = env('APP_URL');

        foreach ($traces as $trace) {
            if ($trace['function'] == 'authenticate') {
                return redirect()->route('login');
            }
        }



        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        $e = $this->prepareException($e);
        $message = $e->getMessage();

        if ($this->isHttpException($e)) {

            return redirect()->route('painel');
        }

        if ($message == "CSRF token mismatch."){
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired'
            ], $e->getStatusCode());
        }






        /*
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            switch (get_class($e->getPrevious())) {
                case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Token has expired'
                    ], $e->getStatusCode());
                case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Token is invalid'
                    ], $e->getStatusCode());
                default:
                    break;
            }
        }

        */





        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->expectsJson()) {
            return response()->view('backend.auth.unauthenticated');
            //return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = Arr::get($exception->guards(),0);

        switch($guard){
            case 'admin';
                return redirect()->guest(route('admin.login'));
                break;
            default:
                return redirect()->guest(url('/login'));
                break;
        }

    }



    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {

        return response()->json($exception->errors(), $exception->status);
    }

}
