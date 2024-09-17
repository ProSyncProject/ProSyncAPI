<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

if (!function_exists('errorLogger')) {
    /**
     * Log error details.
     *
     * @param Throwable $e
     * @param Request $request
     * @return void
     */
    function errorLogger(Throwable $e, Request $request): void
    {
        $stringReq = json_encode($request->all());
        $url = $request->url();
        $method = $request->method();
        $details = "URL: $url
METHOD: $method";
        Log::error(Arr::join(array($e, $details, $stringReq), '

========================================================================

'));
    }
}

if (!function_exists('nanoId')) {
    /**
     * Generate a unique id.
     *
     * @return string
     */
    function nanoId(): string
    {
        return (new \Hidehalo\Nanoid\Client())->formattedId('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 13);
    }
}
