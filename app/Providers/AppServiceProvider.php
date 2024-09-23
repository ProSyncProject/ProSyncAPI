<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\InfoObject;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
        Schema::defaultStringLength(191);

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->setInfo(new InfoObject("ProSync API", "1.0.0"));
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
                    ->setDescription('JWT Bearer Token. (`Bearer ` is prepended automatically)')
            );
        });

        Scramble::registerApi('v1', [
            'api_path' => 'api/v1',
        ]);

        JsonResource::withoutWrapping();

        Response::macro('success', function ($data, $message = null, $status = 200) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $status);
        });

        Response::macro('error', function (string | Throwable $e, $status = 400) {
            return response()->json([
                'status' => $status,
                'message' => $e instanceof Throwable ? $e->getMessage() : $e,
                'data' => null
            ], $status);
        });

        Response::macro('validate', function ($field, $message, $status = 422) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'errors' => [
                    $field => [$message]
                ]
            ], $status);
        });

        Gate::policy(\App\Models\Project::class, \App\Policies\ProjectPolicy::class);
    }
}
