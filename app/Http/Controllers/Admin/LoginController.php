<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('admin')->only(['login','showLoginForm']);
    }


    public function showLoginForm()
    {
        $this->setPageTitle('ورود');
        $this->setCartContent();
        return view('admin.auth.login');
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile'   => 'required',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('admin')->attempt([
            'mobile' => $request->mobile,
            'password' => $request->password
        ], $request->get('remember'))) {
            $this->setPageTitle('داشبورد');
            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->withInput($request->only('mobile', 'remember'))->withErrors([
            'mobile' => [trans('auth.failed')]
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
