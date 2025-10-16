<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, $moduleId)
    {
        $user = Auth::user();

        $isActive = $user->userModules()
                         ->where('module_id', $moduleId)
                         ->where('active', true)
                         ->exists();

        if (!$isActive) {
            return response()->json([
                'error' => 'Module inactive. Please activate this module to use it.'
            ], 403);
        }

        return $next($request);
    }
}   
