<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        $this->setPageTitle('ورود');
        return view('site.auth.login');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        if ($request->has('mobile')) {
            $mobile = str_replace('-', '', $request->get('mobile'));
        }


        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required|min:6'
        ]);

        //authentication users with laravel Hash
        if ($user = Auth::guard('site')->attempt([
            'mobile' => $this->getClean($mobile),
            'password' => $this->getClean($request->password)
        ])) {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();

            $this->setPageTitle('داشبورد');
            return redirect()->intended(route('site.home.index'));
        }

        //authentication users with YII2 Hash
        if ($user = yii2PasswordChecker(
            $mobile,
            $request->password
        )
        ) {
            //for converting old user password(yii2 password) to laravel hashing password
            $user->password = Hash::make($this->getClean($request->password));
            $user->active = 1;
            $user->last_login = Carbon::now();
            $user->save();

            Auth::login($user);

            $this->setPageTitle('داشبورد');
            return redirect()->intended(route('site.home.index'));
        }


        return back()->withInput($request->only('mobile'))->withErrors([
            'mobile' => [trans('auth.failed')],
        ]);
    }

    public function username()
    {
        return 'mobile';
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('site')->logout();

        $request->session()->invalidate();

        $request->session()->flush();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
    }

    protected function loggedOut(Request $request)
    {
        return redirect(route('site.home.index'))->setCache(['max_age' => 0]);
    }
}

