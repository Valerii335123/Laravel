<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param $request
     * @param array $guards
     * @return JsonResponse
     */
    protected function unauthenticated($request, array $guards): JsonResponse
    {
        abort(new JsonResponse(['message' => __('UnAuthenticated')], 401));
    }
}
