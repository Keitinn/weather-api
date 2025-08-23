<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VercelDebugMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vercel用デバッグログ
        \Log::info('Vercel Debug - Request received', [
            'url' => $request->url(),
            'method' => $request->method(),
            'path' => $request->path(),
            'headers' => $request->headers->all(),
            'query' => $request->query(),
            'server' => [
                'REQUEST_URI' => $request->server('REQUEST_URI'),
                'PATH_INFO' => $request->server('PATH_INFO'),
                'SCRIPT_NAME' => $request->server('SCRIPT_NAME'),
                'HTTP_HOST' => $request->server('HTTP_HOST'),
            ]
        ]);

        $response = $next($request);

        \Log::info('Vercel Debug - Response generated', [
            'status' => $response->status(),
            'headers' => $response->headers->all()
        ]);

        return $response;
    }
}
