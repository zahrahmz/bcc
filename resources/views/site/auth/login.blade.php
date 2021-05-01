@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">
                    ورود کاربر
                </h1>
            </div>
            <div class="col-12 col-md-6 registered-customer">
                <p class="registered-customer__subtitle">
                    در صورتی که حساب کاربری دارید، با استفاده از آدرس ایمیل خود وارد شوید.
                </p>
                <form class="registered-customer__login-form" method="post" action="{{ route('site.login.store') }}">
                    @csrf
                    <div class="form-group text-right">
                        <label class="required" for="reg-mobile">
                            موبایل
                        </label>
                        <input type="text" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" name="mobile"  required>
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <label class="required" for="login-pass">
                            کلمه عبور
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="login-pass" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
{{--                    {!! NoCaptcha::renderJs() !!}--}}
{{--                    {!! NoCaptcha::display() !!}--}}
                    <div class="d-flex justify-content-between flex-column flex-md-row">
                        <button class="btn action-btn mb-4 mb-md-3" type="submit">ورود</button>
                        <a href="{{ route('password.request') }}" class="forgot-password text-center">
                            فراموشی رمز عبور
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 text-right new-customer">
                <h3 class="new-customer__title">
                    ثبت نام
                </h3>
                <p  class="new-customer__subtitle">
                    ایجاد یک حساب مزایای بسیاری دارد: سریعتر بررسی کنید ، بیش از یک آدرس را نگه دارید ، سفارشات را ردیابی کنید و موارد دیگر.
                </p>
                <div class="d-flex flex-column flex-md-row justify-content-center">
                    <a class="btn action-btn" href="{{ route('site.register') }}">ایجاد حساب کاربری</a>
                </div>
            </div>
        </div>
    </div>
@endsection
