<?php

namespace App\Common\Infrastructure\Lumen\Exceptions;

use Closure;
use Laravel\Lumen\Exceptions\Handler as ExceptionsHandler;
use Throwable;

class Handler extends ExceptionsHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * The callbacks that should be used during reporting.
     *
     * @var \App\Common\Infrastructure\Lumen\Exceptions\ReportableHandler[]
     */
    protected $reportCallbacks = [];
    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register a reportable callback.
     *
     * @param  callable  $reportUsing
     * @return \App\Common\Infrastructure\Lumen\Exceptions\ReportableHandler
     */
    public function reportable(callable $reportUsing)
    {
        if (!$reportUsing instanceof Closure) {
            $reportUsing = Closure::fromCallable($reportUsing);
        }

        return tap(new ReportableHandler($reportUsing), function ($callback) {
            $this->reportCallbacks[] = $callback;
        });
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
