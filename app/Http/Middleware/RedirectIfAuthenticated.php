<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                switch ($user->user_type) {
                    case 'admin':
                        return redirect()->route('admin.panel');
                    case 'manager':
                        return redirect()->route('manager.panel');
                    case 'laborer':
                        return redirect()->route('laborer.panel');
                    case 'customer':
                        return redirect()->route('customer.panel');
                    default:
                        return redirect()->route('home'); // fallback
                }
            }
        }

        return $next($request);
    }

}
