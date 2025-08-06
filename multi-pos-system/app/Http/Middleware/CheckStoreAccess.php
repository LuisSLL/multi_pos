<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Super admin can access everything
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }
        
        // Check if user has a store
        if (!$user || !$user->store_id) {
            return redirect()->route('store.setup');
        }
        
        // Check if store is active
        if ($user->store && !$user->store->is_active) {
            return redirect('/suspended')->with('error', 'Your store access has been suspended. Please contact support.');
        }
        
        return $next($request);
    }
}
