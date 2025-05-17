<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Jika route adalah profile, izinkan akses ke profil sendiri
        if ($request->routeIs('user.profile') && $request->route('id') == $user->user_id) {
            return $next($request);
        }

        $user_role = $user->getRole();
        if (in_array($user_role, $roles)) {
            return $next($request);
        }

        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}
