<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Site\Auth\ForgotPasswordRequest;
use App\Jobs\SendResetPasswordSmsJob;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        $this->setPageTitle('فراموشی رمز ورود');
        return view('site.auth.forgot');
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $this->dispatch(new SendResetPasswordSmsJob($request->get('mobile')));
        return redirect()->route('password.reset.sentSuccessfully');
    }

    public function sentSuccessfully()
    {
        $this->setPageTitle('بازیابی رمز عبور');
        return view('site.auth.resetPasswordLinkSent');
    }
}

