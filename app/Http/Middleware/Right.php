<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

class Right {
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $right) {
        if (empty(Auth::user())) {
            $return = [
                'error' => 'authError',
                'message' => 'Authentication required!'
            ];

            return response()->json($return);
        }

        if (!$request->user()->hasRole($right)) {
            $return = [
                'error' => 'permissionError',
                'message' => 'Not authorized to use this function!'
            ];

            return response()->json($return);
        }

        return $next($request);
    }
}