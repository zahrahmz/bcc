@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">
                    سبد خرید
                </h1>
            </div>
        </div>
        {{--        <div class="row">--}}
        {{--            <div class="col-12">--}}
        {{--                <p>سبد خرید شما خالی است.</p>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="row flex-column-reverse flex-sm-row">
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col-12">
                        <table class="cart-table">
                            <thead>
                            <tr>
                                <th class="first">
                                    محصول
                                </th>
                                <th>
                                    قیمت
                                </th>
                                <th>
                                    تعداد
                                </th>
                                <th>
                                    قیمت کل
                                </th>
                            </tr>
                            </thead>
                            <tbody class="cart-item-wrapper">
                            <tr>
                                <td class="product-info">
                                    <a class="product-info__image" href="">
                                        <img
                                            src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                            alt="">
                                    </a>
                                    <div class="product-info__details">
                                        <a class="product-info__title" href="">عنوان محصول</a>
                                        <span class="d-flex align-items-baseline mt-4 mt-md-5">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                    </div>
                                </td>
                                <td class="secondary">
                                    <strong>
                                        123000 تومان
                                    </strong>
                                </td>
                                <td class="secondary quantity-col">
                                    2
                                </td>
                                <td class="secondary">
                                    <strong>
                                        123000 تومان
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" colspan="100">
                                    <div class="cart-item__actions">
                                        <div class="cart-item-action-btns">
                                            <button class="btn ml-4">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tbody class="cart-item-wrapper">
                            <tr>
                                <td class="product-info">
                                    <a class="product-info__image" href="">
                                        <img
                                            src="https://www.babycottons.com/media/catalog/product/cache/2f58bf1051a2f0ceba166b720ec0a490/4/5/4520321247_r05_1_2.jpg"
                                            alt="">
                                    </a>
                                    <div class="product-info__details">
                                        <a class="product-info__title" href="">عنوان محصول</a>
                                        <span class="d-flex align-items-baseline mt-4 mt-md-5">
                                    <b class="ml-2">سایز:</b>
                                    4 سال
                                </span>
                                    </div>
                                </td>
                                <td class="secondary">
                                    <strong>
                                        123000 تومان
                                    </strong>
                                </td>
                                <td class="secondary quantity-col">
                                    2
                                </td>
                                <td class="secondary">
                                    <strong>
                                        123000 تومان
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" colspan="100">
                                    <div class="cart-item__actions">
                                        <div class="cart-item-action-btns">
                                            <button class="btn ml-4">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex flex-column mb-5">
                            <a class="btn show-discount-input-btn d-flex align-items-center" data-toggle="collapse"
                               href="#discountCodeInput" role="button"
                               aria-expanded="true" aria-controls="discountCodeInput">
                                استفاده از کد تخفیف
                                <i class="fas fa-angle-up"></i>
                            </a>
                            <div class="collapse show" id="discountCodeInput">
                                <div class="d-flex cart-discount">
                                    <input class="form-control" type="text">
                                    <button class="btn action-btn" type="button">
                                        اعمال تخفیف
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="cart-summary mb-5">
                    <h4 class="cart-summary__title d-none d-md-block">خلاصه</h4>
                    <div class="row mb-4">
                        <div class="col-12">
                            <button class="btn action-btn w-100">
                                ادامه فرآیند خرید
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="w-100">
                                <tbody>
                                <tr>
                                    <th class="text-right py-3">
                                        مجموع قیمت
                                    </th>
                                    <td class="py-3">
                                        10000000 تومان
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-right py-3">
                                        مالیات
                                    </th>
                                    <td class="py-3">
                                        10000 تومان
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
