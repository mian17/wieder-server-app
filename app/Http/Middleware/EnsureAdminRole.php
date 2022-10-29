<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $loggedInUser = User::whereEmail($request->get('email'))->first();

        if (!$loggedInUser) {
            return response('Email hoặc mật khẩu sai', 401);
        }

        $loggedInUserRoles = $loggedInUser->roles->pluck('id')->all();

        $ADMIN_ROLE = 1;
        $MODERATOR_ROLE = 2;

        if (in_array($ADMIN_ROLE, $loggedInUserRoles, true) || in_array($MODERATOR_ROLE, $loggedInUserRoles, true)) {
            return $next($request);
        }
        return response(['message' =>'Bạn không có quyền truy cập trang này'], 401);
    }
}
