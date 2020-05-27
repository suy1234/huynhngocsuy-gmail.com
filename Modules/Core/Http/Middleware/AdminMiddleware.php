<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user != null) {
            return $next($request);
        }
        return redirect()->route('admin.login');
    }
}
