<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function handle(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'password.required' => 'Vui lòng nhập mật khẩu'
            ]
        );
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                if (time() > $user->ban_time) {
                    Auth::login($user);
                    return redirect(route('home'));
                } else {
                    return back()->with('authErr', 'Tài khoản của bạn đang bị khóa cho đến <b>' . date('H:i d/m/Y', $user->ban_time) .'</b>. <br>Chi tiết liên hệ hotro@nzfashion.com hoặc hotline: 19001990');
                }
            } else {
                return back()->with('authErr', 'Mật khẩu không chính xác!');
            }
        } else {
            return back()->with('authErr', 'Địa chỉ email không tồn tại!');
        }
    }
}
