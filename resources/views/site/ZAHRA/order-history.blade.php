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
                                تاریخچه سفارشات
                            </h1>
                        </div>
                    </div>
                    <div class="row border-bottom mb-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-sm-3 d-flex">
                                    <label class="ml-3" for="">مبلغ کل:</label>
                                    <p>123456789 تومان</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex justify-content-center">
                                    <p>22 اسفند 1399</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex">
                                    <label class="ml-3" for="">شماره سفارش:</label>
                                    <p>7895462</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex justify-content-center justify-content-sm-end">
                                    <a href="">مشاهده سفارش</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 order-history-images-container d-flex py-4">
                                    <div class="overflow-auto d-flex">
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom mb-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-sm-3 d-flex">
                                    <label class="ml-3" for="">مبلغ کل:</label>
                                    <p>123456789 تومان</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex justify-content-center">
                                    <p>22 اسفند 1399</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex">
                                    <label class="ml-3" for="">شماره سفارش:</label>
                                    <p>7895462</p>
                                </div>
                                <div class="col-6 col-sm-3 d-flex justify-content-center justify-content-sm-end">
                                    <a href="">مشاهده سفارش</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 order-history-images-container d-flex py-4">
                                    <div class="overflow-auto d-flex">
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                        <a class="order-history-image" href="">
                                            <img
                                                src="https://ibolak.com/uploads/image/2021/4/optimized/1619259547-qKZsztzN3rzio3Fc.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
