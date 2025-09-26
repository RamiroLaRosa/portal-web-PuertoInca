<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next): Response
    {
        if(!Auth::check() && ($request->path()!='login')){

            return redirect()->route('login');
        }
        if(Auth::check() && (($request->path()=='login') || ($request->path()=='/'))){
            return back();
        }
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Cache-Control', 'post-check=0, pre-check=0', false);
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return  $response;
    }
}

