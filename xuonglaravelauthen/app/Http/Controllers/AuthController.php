<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class AuthController extends Controller
{
    public function showFormLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $user = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember');

        if (Auth::attempt($user,$remember)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không khớp với hồ sơ của chúng tôi.',
        ])->onlyInput('email');
    }
    public function showFormRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',


        ]);
        $user = User::query()->create($data);
        Auth::login($user);
        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return back();
    }
    public function showformforgot()
    {
        return view('auth.forgot');
    }
    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Tạo mã OTP
        $otp = Str::random(6); // hoặc bạn có thể dùng một phương pháp tạo mã khác
        // Lưu mã OTP vào session (hoặc bạn có thể lưu vào database tạm thời)
        session(['otp' => $otp, 'otp_email' => $request->email]);

        // Gửi email chứa mã OTP
        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('showOtpForm')->with('status', 'Mã OTP đã được gửi đến email của bạn.');
    }
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function Otp(Request $request)
    {

        $request->validate(['otp' => 'required|string']);

        // Kiểm tra mã OTP
        if ($request->otp ==session('otp')) {
            return redirect()->route('showFormRest', ['token' => request('token')]); // Chuyển đến trang reset mật khẩu
        }

        return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
    }
    public function showFormRest(){
        return view('auth.resetpass');
    }
    public function reset(Request $request){
        $user = User::where('email', session()->get('otp_email'))->first();
    if ($user) {
        $user->password = Hash::make($request->password); // Hash mật khẩu mới
        $user->save(); // Lưu vào cơ sở dữ liệu

        // Xóa OTP khỏi session sau khi đổi mật khẩu thành công
        $request->session()->forget(['otp', 'otp_email']);

        // Đăng nhập người dùng hoặc redirect tới trang đăng nhập
        return redirect()->route('login')->with('status', 'Mật khẩu đã được đổi thành công, vui lòng đăng nhập lại.');
    }

    }



    //
}
