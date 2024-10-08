<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/solicitacoes/criar';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $user = Auth::getProvider()->retrieveByCredentials($request->only($this->username()));

        if (!$user) {
            return $this->sendFailedLoginResponse($request, 'email');
        }

        if (!Auth::validate($credentials)) {
            return $this->sendFailedLoginResponse($request, 'password');
        }

        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    protected function sendFailedLoginResponse(Request $request, $type)
    {
        if ($type == 'email') {
            throw ValidationException::withMessages([
                $this->username() => ['Email incorrect.'],
            ]);
        }

        if ($type == 'password') {
            throw ValidationException::withMessages([
                'password' => ['Password incorrect.'],
            ]);
        }
    }
}
