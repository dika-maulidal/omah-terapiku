<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role_display();

        if (!in_array($userRole, $roles)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Peran Anda (' . $userRole . ') tidak memiliki wewenang untuk tindakan ini.'
                ], 403);
            }

            abort(403, 'Akses tidak diizinkan. Peran Anda (' . $userRole . ') tidak memiliki wewenang untuk mengakses halaman atau fitur ini.');
        }

        return $next($request);
    }
}
