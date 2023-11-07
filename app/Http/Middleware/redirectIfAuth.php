<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class redirectIfAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->get('username')) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
