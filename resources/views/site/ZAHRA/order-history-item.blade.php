@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row pt-5">
            <div class="col-12 col-md-3">
                @include('site.ZAHRA.profile-sidebar')
            </div>
            <div class="col-12 col-md-9">
                <div class="profile-page shopping-history-table">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="page-title">
                                جزئیات سفارش
                            </h1>
                        </div>
                    </div>
                    <div class="row border-bottom mb-2">
                        <div class="col-md-3 col-6 d-flex">
                            <label class="ml-1" for="">تحویل گیرنده: </label>
                            <p>زهرا حمزه</p>
                        </div>
                        <div class="col-md-3 col-6 d-flex">
                            <label class="ml-1" for="">شماره تماس: </label>
                            <p>09100066344</p>
                        </div>
                        <div class="col-6 d-flex justify-content-md-end">
                            <label class="ml-1" for="">تاریخ: </label>
                            <p>16/02/1400</p>
                        </div>
                        <div class="col-12 d-flex">
                            <label class="ml-1" for="">آدرس: </label>
                            <p>تهران، پاسداران، بوستان ششم، پلاک 446، طبقه 2، </p>
                        </div>
                    </div>
                    <div class="row border-bottom mb-5">
                        <div class="col-md-3 col-6 d-flex">
                            <label class="ml-1" for="">مبلغ کل:</label>
                            <p>265000 تومان</p>
                        </div>
                        <div class="col-md-3 col-6 d-flex">
                            <label class="ml-1" for="">تخفیف:</label>
                            <p>10000 تومان</p>
                        </div>
                    </div>
                    <div class="row border-bottom pb-4 mb-4 shopping-history-item-wrapper">
                        <div class="col-12 col-md-6 d-flex">
                            <a class="shopping-history__image d-flex" href="">
                                <img
                                    src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                    alt="">
                            </a>
                            <div class="d-flex flex-column flex-grow-1">
                                <a class="shopping-history__title" href="">عنوان محصول</a>
                                <span class="d-flex align-items-baseline mt-2">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">تعداد:</b>
                                                                    2
                                                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">قیمت:</b>
                                                                    120000
                                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom pb-4 mb-4 shopping-history-item-wrapper">
                        <div class="col-12 col-md-6 d-flex">
                            <a class="shopping-history__image d-flex" href="">
                                <img
                                    src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                    alt="">
                            </a>
                            <div class="d-flex flex-column flex-grow-1">
                                <a class="shopping-history__title" href="">عنوان محصول</a>
                                <span class="d-flex align-items-baseline mt-2">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">تعداد:</b>
                                                                    2
                                                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">قیمت:</b>
                                                                    120000
                                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom pb-4 mb-4 shopping-history-item-wrapper">
                        <div class="col-12 col-md-6 d-flex">
                            <a class="shopping-history__image d-flex" href="">
                                <img
                                    src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                    alt="">
                            </a>
                            <div class="d-flex flex-column flex-grow-1">
                                <a class="shopping-history__title" href="">عنوان محصول</a>
                                <span class="d-flex align-items-baseline mt-2">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">تعداد:</b>
                                                                    2
                                                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">قیمت:</b>
                                                                    120000
                                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom pb-4 mb-4 shopping-history-item-wrapper">
                        <div class="col-12 col-md-6 d-flex">
                            <a class="shopping-history__image d-flex" href="">
                                <img
                                    src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                    alt="">
                            </a>
                            <div class="d-flex flex-column flex-grow-1">
                                <a class="shopping-history__title" href="">عنوان محصول</a>
                                <span class="d-flex align-items-baseline mt-2">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">تعداد:</b>
                                                                    2
                                                                </span>
                                <span class="d-flex align-items-baseline mt-2">
                                                                    <b class="ml-2">قیمت:</b>
                                                                    120000
                                                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
