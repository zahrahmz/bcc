<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Site\Auth\ResetPasswordRequest;
use App\Models\Site\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm()
    {
        $this->setPageTitle('بازنشانی رمز ورود');
        sleep(10);//let mysql sync read and write PDO
        return view('site.auth.reset');
    }

    public function reset(ResetPasswordRequest $request)
    {
        $userMobile = DB::table('password_resets')->where('token', $request->token)->first()->mobile;
        $user = User::query()->where('mobile', $userMobile)->first();
        $user->update(['password'=>bcrypt($request->password)]);

        Auth::guard('site')->login($user);
        return redirect(route('site.home.index'));
    }
}

