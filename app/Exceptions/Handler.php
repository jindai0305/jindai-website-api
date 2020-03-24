<?php

namespace App\Exceptions;

use App\Support\Response;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof CustomizeException) {
            return parent::render($request, $exception);
        }

        if (is_callable([$exception, 'getStatusCode'])) {
            $code = $exception->getStatusCode();
            if ($code === 401) {
                return $this->unauthenticated($request, new AuthenticationException($exception->getMessage()));
            } elseif ($code === 403) {
                return $this->accessDenied($request, new AccessDeniedHttpException($exception->getMessage(), $exception));
            } elseif ($code === 404) {
                return $this->notfound($request, new NotFoundHttpException($exception->getMessage(), $exception));
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * @inheritdoc
     */
    protected function prepareException(Exception $e)
    {
        return parent::prepareException($e);
    }

    /**
     * @inheritdoc
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json([
                'error_code' => 401,
                'error_msg' => $exception->getMessage(),
                'data' => ''
            ], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param AccessDeniedHttpException $exception
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function accessDenied($request, AccessDeniedHttpException $exception)
    {
        return $request->expectsJson()
            ? response()->json($this->accessDeniedContent($exception), 403)
            : $this->prepareResponse($request, $exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param NotFoundHttpException $e
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function notfound($request, NotFoundHttpException $e)
    {
        return $request->expectsJson()
            ? response()->json($this->notfoundContent($e), 404)
            : $this->prepareResponse($request, $e);
    }

    /**
     * @inheritdoc
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'error_code' => $exception->status,
            'error_msg' => $exception->getMessage(),
            'data' => $exception->errors(),
        ], $exception->status);
    }

    /**
     * @inheritdoc
     */
    protected function convertExceptionToArray(Exception $e)
    {
        if ($e instanceof AccessDeniedHttpException) {
            return $this->accessDeniedContent($e);
        }
        if ($e instanceof NotFoundHttpException) {
            return $this->notfoundContent($e);
        }
        return $this->fetchErrorData($e);
    }

    /**
     * @param AccessDeniedHttpException $e
     * @return array
     */
    protected function accessDeniedContent(AccessDeniedHttpException $e)
    {
        return [
            'error_code' => 403,
            'error_msg' => $e->getMessage() ?: 'Access denied',
            'data' => $this->fetchErrorData($e)
        ];
    }

    /**
     * @param NotFoundHttpException $e
     * @return array
     */
    protected function notfoundContent(NotFoundHttpException $e)
    {
        return [
            'error_code' => 404,
            'error_msg' => $e->getMessage() ?: 'Path does not match',
            'data' => []
//            'data' => $this->fetchErrorData($e)
        ];
    }

    /**
     * @param Exception $e
     * @return array
     */
    protected function fetchErrorData(\Exception $e)
    {
        return config('app.debug') ? [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
        ];
    }
}
