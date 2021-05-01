@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">
                    ثبت نام کاربر جدید
                </h1>
            </div>
            <div class="col-md-6 col-12">
                <form class="register-form" action="{{ route('site.register.store') }}" method="post">
                    @csrf
                    <h4 class="register-form__title">
                        اطلاعات فردی
                    </h4>
                    <section>
                        <div class="form-group text-right">
                            <label class="required" for="reg-lastname">
                                نام و نام خانوادگی
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="reg-lastname" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <label class="required" for="reg-phone">
                                موبایل
                            </label>
                            <input type="text" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" name="mobile" id="reg-phone" required>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </section>
                    <h4 class="register-form__title">
                        اطلاعات حساب کاربری
                    </h4>
                    <section>
                        <div class="form-group text-right">
                            <label class="" for="reg-email">
                                ایمیل
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <label class="required" for="reg-pass">
                                رمز عبور
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" id="reg-pass" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <label class="required" for="reg-repass">
                                تکرار رمز عبور
                            </label>
                            <input type="password" class="form-control" name="password_confirmation" id="reg-repass"
                                   required>
                        </div>
                    </section>
                    <div class="d-flex justify-content-start flex-column flex-md-row mt-5">
                        <button class="btn action-btn" type="submit">ایجاد حساب کاربری</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


