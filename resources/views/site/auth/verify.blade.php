@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title text-center">
                    تایید کاربر
                </h1>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <form class="forgot-password-form" action="{{ route('site.verify.store') }}" method="post">
                        @csrf
                        <p>
                            لطفا کد ارسال شده به موبایل خود را وارد کنید
                        </p>
                        <div class="form-group text-right">
                            <label class="required" for="reg-email">
                                کد تایید
                            </label>
                            <input type="text" class="form-control" name="verification_code" id="reg-email" required>
                            <input type="hidden" class="form-control" name="mobile" id="reg-email" value="{{ $mobile }}" required>
                            <a href="#" class="resend">ارسال دوباره کد</a>
                            @error('verification_code')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center flex-column flex-md-row mt-5">
                            <button class="btn action-btn" type="submit">تایید</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $(".resend").click(function () {


                $.ajax({
                    type: 'GET',
                    url: "{{ route('site.verify.resend.sms',['mobile' => $mobile]) }}",
                    async: true,
                    dataType: 'json',
                    success:function(data) {
                        $(".resend").text('ارسال شد')
                    },
                    beforeSend: function (xhr) {
                        $(".resend").css("color",'grey');
                        $(".resend").text('در حال ارسال . . . ')
                    }
                });
            });
        });
    </script>
@endpush
