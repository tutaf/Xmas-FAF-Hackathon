<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class API
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('access_token', $request->access_token)->first();

        if ($user && $request->access_token !== NULL) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
