<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('home'); // atau ke login, bebas
        }

        return $next($request);
    }
}

class ConvertEmptyStringsToNull
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge(array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $request->all()));

        return $next($request);
    }
}

class TrimStrings
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge(array_map('trim', $request->all()));

        return $next($request);
    }
}

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // URL yang tidak memerlukan CSRF
    ];
}

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    protected $except = [
        // Cookies yang tidak akan dienkripsi
    ];
}
