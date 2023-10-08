<?php

namespace App\Common\Infrastructure\Lumen\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::macro('success', function ($data, $code = HttpResponse::HTTP_OK) {
            if ($data instanceof \JsonSerializable) {
                $data = $data->jsonSerialize();
            }
            return response()->json($data, $code);
        });

        ResponseFactory::macro('created', function ($data, $code = HttpResponse::HTTP_CREATED) {
            if ($data instanceof \JsonSerializable) {
                $data = $data->jsonSerialize();
            }
            return response()->json($data, $code);
        });

        ResponseFactory::macro('accepted', function ($data, $code = HttpResponse::HTTP_ACCEPTED) {
            if ($data instanceof \JsonSerializable) {
                $data = $data->jsonSerialize();
            }
            return response()->json($data, $code);
        });

        ResponseFactory::macro('noContent', function ($code = HttpResponse::HTTP_NO_CONTENT) {
            return response('',$code);
        });

        ResponseFactory::macro('unauthorized', function ($data, $code = HttpResponse::HTTP_UNAUTHORIZED) {
            if ($data instanceof \JsonSerializable) {
                $data = $data->jsonSerialize();
            }
            return response()->json($data, $code);
        });

        ResponseFactory::macro('error', function ($message, $code = HttpResponse::HTTP_BAD_REQUEST) {
            return response()->json(['error' => $message], $code);
        });

        ResponseFactory::macro('notFound', function ($message, $code = HttpResponse::HTTP_NOT_FOUND) {
            return response()->json(['error' => $message], $code);
        });

        ResponseFactory::macro('forbidden', function ($message, $code = HttpResponse::HTTP_FORBIDDEN) {
            return response()->json(['error' => $message], $code);
        });
    }
}
