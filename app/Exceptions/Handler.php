<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // This handles exceptions from LaravelRoles and flashes the error on the dashboard rather than spitting a 403 page.
        $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;

        if ($userLevelCheck) {
            return back()->with('error', $exception->getMessage());
        }
        return parent::render($request, $exception);
    }
}
