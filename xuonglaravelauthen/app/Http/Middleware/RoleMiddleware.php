<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user(); // Lấy người dùng hiện tại

        // Kiểm tra nếu người dùng không đăng nhập
        if (!$user) {
            return redirect('/login')->with('message', 'Bạn cần đăng nhập để truy cập.');
        }

        // Kiểm tra quyền truy cập dựa trên vai trò
        if ($role === 'admin') {
            if ($user->role !== 'admin') {
                return redirect('/home')->with('message', 'Bạn không có quyền truy cập trang này.');
            }
        } elseif ($role === 'personnel') {
            if (!in_array($user->role, ['admin', 'personnel'])) {
                return redirect('/home')->with('message', 'Bạn không có quyền truy cập trang này.');
            }
        } elseif ($role === 'user') {
            if (!in_array($user->role, ['admin', 'personnel', 'user'])) {
                return redirect('/home')->with('message', 'Bạn không có quyền truy cập trang này.');
            }
        }

        return $next($request);
    }
}
