<?php

namespace App\Http\Middleware;

use App\Http\Controllers\paggeAccess\PageAccessController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class Egresado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            return redirect()->route('modulo.page.egresado');
        
    }

}
