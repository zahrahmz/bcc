@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title text-center">
                    فراموشی رمز عبور
                </h1>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <form class="forgot-password-form" action="{{ route('password.email') }}" method="post">
                        @csrf
                        <p>
                            لطفا شماره موبایل خود را وارد کنید
                        </p>
                        <div class="form-group text-right">
                            <label class="required" for="reg-email">
                                شماره موبایل
                            </label>
                            <input type="text" class="form-control" name="mobile" id="reg-email" required>
                            @error('mobile')
                            <span class="validation-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center flex-column flex-md-row mt-5">
                            <button class="btn action-btn" type="submit">بازیابی رمز عبور</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
