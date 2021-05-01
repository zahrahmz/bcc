<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Jobs\SendSms;
use App\Models\Site\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showRegistrationForm()
    {
        $this->setPageTitle('ثبت نام');
        $this->setCartContent();
        return view('site.auth.register');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (!empty($data['mobile'])) {
            $data['mobile'] = str_replace('-', '', $data['mobile']);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'mobile' => ['required', 'phone:IR', 'unique:users'],
        ]);
    }


    protected function create(array $data)
    {
        $user = User::query()->create([
            'name' => $this->getClean($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($this->getClean($data['password'])),
            'mobile' => PhoneNumber::make($this->getClean($data['mobile']), 'IR')->formatForMobileDialingInCountry('IR'),
            'verification_code' => random_int(1000, 10000)
        ]);

        if ($user) {
            $text = trans('auth.verification_code', ['code' => $user->verification_code]);
            dispatch(new SendSms($user->mobile, $text));
        }

        return $user;
    }


    protected function registered($user)
    {
        Auth::logout();
        return redirect('/verify/' . $user->mobile);
    }

    public function showVerificationForm($mobile)
    {
        $this->setPageTitle('تایید کاربر');
        return view('site.auth.verify', compact('mobile'));
    }

    public function verify(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $user = User::query()
            ->where(
                'mobile',
                $this->getClean($request->get('mobile'))
            )->first();

        if ($user->verification_code == $request->get('verification_code')) {
            Auth::guard('site')->login($user);
            $user->update(['active' => 1, 'mobile_verified_at' => Carbon::now()]);
            return redirect('/');
        } else {
            return back()->withErrors([
                'verification_code' => [trans('auth.fail_verification_code')],
            ]);
        }
    }

    public function resendSms($mobile)
    {
        if ($mobile) {
            $mobile = $this->getClean($mobile);
            $user = User::query()->where('mobile', $mobile)->first();
            if ($user) {
                $text = trans('auth.verification_code', ['code' => $user->verification_code]);
                dispatch(new SendSms($user->mobile, $text));
                return response()->json(['status' => 200]);
            }
        }
    }
}

