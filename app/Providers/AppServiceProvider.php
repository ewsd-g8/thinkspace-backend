<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Response::macro('success', function ($message, $status_code, $data = null) {
            return response()->json([
                'message' => $message,
                'data' => $data
            ], $status_code);
        });

        Response::macro('error', function ($message, $status_code, $data = null) {
            return response()->json([
                'message' => $message,
                'errors' => $data
            ], $status_code);
        });

        // DB::listen(
        //     function ($sql) {
        //         foreach ($sql->bindings as $i => $binding) {
        //             if ($binding instanceof \DateTime) {
        //                 $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
        //             } else {
        //                 if (is_string($binding)) {
        //                     $sql->bindings[$i] = "'$binding'";
        //                 }
        //             }
        //         }
        //         // Insert bindings into query
        //         $query = str_replace(['%', '?'], ['%%', '%s'], $sql->sql);
        //         $query = vsprintf($query, $sql->bindings);
        //         Log::channel('querylog')->debug($query);
        //     }
        // );
    }
}
