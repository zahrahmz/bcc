@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row pt-5">
            <div class="col-12 col-md-3">
                @include('site.ZAHRA.profile-sidebar')
            </div>
            <div class="col-12 col-md-9">
                <div class="profile-page">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="page-title">
                                آدرس های پستی
                            </h1>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12">
                            <p class="profile-section-title">
                                آدرس پیش فرض
                            </p>
                        </div>
                        <div class="col-12">
                            <p>
                                نیما امیری
                            </p>
                            <p>
                                تهران، تهران، تهران و ...
                            </p>
                            <p>
                                کدپستی:
                                1234567890
                            </p>
                            <p>
                                تلفن:
                                09123456789
                            </p>
                            <div class="d-flex">
                                <a class="profile-section-actions text-right" href="">
                                    ویرایش آدرس
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="profile-section-title">
                                سایر آدرس ها
                            </p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex flex-column align-items-start mb-3">
                            <address class="flex-grow-1">
                                <p>
                                    نیما امیری
                                </p>
                                <p>
                                    تهران، پاسداران، بوستان ششم، تهران، پاسداران، بوستان ششم
                                </p>
                                <p>
                                    کدپستی:
                                    12345678
                                </p>
                                <p>
                                    تلفن:
                                    12345678
                                </p>
                            </address>
                            <div class="d-flex">
                                <a class="profile-section-actions pl-4 border-left ml-4" href="">
                                    ویرایش آدرس
                                </a>
                                <a class="profile-section-actions" href="">حذف آدرس</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex flex-column align-items-start mb-3">
                            <address class="flex-grow-1">
                                <p>
                                    نیما امیری
                                </p>
                                <p>
                                    تهران، پاسداران، بوستان ششم
                                </p>
                                <p>
                                    کدپستی:
                                    12345678
                                </p>
                                <p>
                                    تلفن:
                                    12345678
                                </p>
                            </address>
                            <div class="d-flex">
                                <a class="profile-section-actions pl-4 border-left ml-4" href="">
                                    ویرایش آدرس
                                </a>
                                <a class="profile-section-actions" href="">حذف آدرس</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-md-row margin-top-4">
                        <button class="btn action-btn">
                            افزودن آدرس جدید
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
