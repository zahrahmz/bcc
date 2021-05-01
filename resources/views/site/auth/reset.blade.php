@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title text-center">

                </h1>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <form class="forgot-password-form" action="{{ route('password.reset.store') }}" method="post">
                        @csrf
                        <p>
                            لطفا رمز عبور <b>جدید</b> خود را وارد کنید
                        </p>
                        <div class="form-group text-right">
                            <label class="required" for="reg-email">
                                رمز عبور
                            </label>
                            <input type="text" class="form-control" name="password" id="reg-email" required>
                            @error('mobile')
                            <span class="validation-error" role="alert">
                                <strong>{{ $message }}</strong>
                             </span>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <input type="hidden" class="form-control" value="{{ request()->token }}" name="token" id="reg-email" required>
                        </div>
                        <div class="d-flex justify-content-center flex-column flex-md-row mt-5">
                            <button class="btn action-btn" type="submit">بازنشانی رمز عبور</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
