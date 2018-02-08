<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Response as HttpResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Macros\Database\Schema\Blueprint::registerMacros();

        HttpResponse::macro('api', function ($data, $message = '', $code = 200) {
            return response()->json([
                'data'    => $data,
                'message' => $message,
                'code'    => $code,
            ]);
        });

        HttpResponse::macro('excel', function ($data) {
            //
        });

        HttpResponse::macro('pdf', function ($data) {
            //
        });

        User::macro('hello', function () {
            return 'hello world';
        });

        User::macro('register', function () {
            // register...
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
