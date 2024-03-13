<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Can
{
    public function handle(Request $request, \Closure $next) {
        Log::info('Can middleware');
        $currentRoute = $request->route()->getName();


        // check if user can access the route by the route name (screen)

        $user = $request->user();

        if ($user->can($currentRoute)) {
            return $next($request);
        }

        return $next($request);
    }
}