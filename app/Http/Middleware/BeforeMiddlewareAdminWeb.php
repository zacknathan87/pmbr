<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Response;

class BeforeMiddlewareAdminWeb {

    public function handle($request, Closure $next) {
        // Perform action

        
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect('/admin-management/login');
        }

        return $next($request);
    }

}
