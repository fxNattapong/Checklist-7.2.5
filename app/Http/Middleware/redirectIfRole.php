<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class redirectIfRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->session()->get('role') != '2') {
            return redirect('/admin');
        }
        return $next($request);
    }
}
