<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $hasuid = $request->session()->has('uid');
        if ($hasuid) return $next($request);
        else return redirect()->route('chatbot.welcome');
    }
}
