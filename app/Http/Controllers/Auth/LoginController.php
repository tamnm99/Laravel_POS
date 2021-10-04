<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;

use App\Models\User;

use GuzzleHttp\Client;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

session_start();


class LoginController extends Controller
{
    /**
     * Hàm index
     */
    public function index()
    {
        return view('dashboard.auth.login');
    }

    public function process(LoginRequest $request)
    {
       $request->validated();

        $gRecaptcha = $request->grecaptcha;

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                    [
                        'secret' => env('google_captcha_secrect'),
                        'response' => $gRecaptcha
                    ]
            ]
        );
        $body = json_decode((string)$response->getBody());
        if ($body->success == true) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->email_verified_at) {
                        if (auth()->attempt($request->only('email', 'password'))) {
                            $user = Auth::user();
                            return redirect()->intended(route('admin.dashboard'))->with('success',
                                'Chào mừng quay trở lại ' . $user->full_name);
                        }
                    } else {
                        return redirect()->back()->withInput()->with('error', 'Email này chưa được xác thực');
                    }
                } else {
                    return redirect()->back()->withInput()->with('error', 'Mật khẩu không đúng');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Email này không tồn tại trong DB');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Google recaptcha không hợp lệ');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect(route('login'));
    }
}
