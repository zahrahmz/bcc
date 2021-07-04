@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row justify-content-center not-found">
            <div class="col-12 d-flex flex-column align-items-center">
                <h1 class="page-title">
                    404
                </h1>
                <h3>
                    متاسفانه صفحه‌ای که دنبال آن بودید پیدا نشد!
                </h3>
            </div>
            <div class="col-12 col-md-6" style="margin-top:80px;">
                <div class="row">
                    <div class="col-md-4">
                        <a class="btn action-btn w-100">
                            صفحه اصلی
                        </a></div>
                    <div class="col-md-4">
                        <a class="btn action-btn w-100">
                            لیست محصولات
                        </a></div>
                    <div class="col-md-4">
                        <a class="btn action-btn w-100">
                            پروفایل کاربری
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
