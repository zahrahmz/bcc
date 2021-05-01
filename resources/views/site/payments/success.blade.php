@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-9 col-md-5 col-lg-4">
            <div class="after-payment-card success">
                <img src="{{ asset('/site/images/check.png') }}" alt="">
                <strong class="my-5">
                    پرداخت شما با موفقیت انجام شد.
                </strong>
                <div class="d-flex justify-content-around w-100 py-3">
                    <p class="m-0">کد پیگیری:</p>
                    <p class="m-0">{{ $invoice->referenceId }}</p>
                </div>
                <hr class="w-100">
                <a href="/" class="btn action-btn mt-3">
                    بازگشت به صفحه اصلی
                </a>
            </div>
        </div>
    </div>
</div>
@endsection