<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        // ตรวจสอบว่ามี user_id อยู่ใน session หรือไม่
        if (!session()->has('user_id')) {
            return redirect('/signin')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        return $next($request);
    }
}

