<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang');
        if ($lang && in_array($lang, ['en', 'id'])) {
            App::setLocale($lang);
        }

        return $next($request);
    }
}
