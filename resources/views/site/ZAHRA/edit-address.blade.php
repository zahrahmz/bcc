@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row pt-3 pt-md-5">
            <div class="col-12 col-md-3">
                @include('site.ZAHRA.profile-sidebar')
            </div>
            <div class="col-12 col-md-9">
                <div class="profile-page address-book-page">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="page-title">
                                افزودن آدرس جدید
                            </h1>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <form class="w-100" action="">
                            <div class="col-12 col-md-6">
                                <div class="form-group text-right">
                                    <label class="required" for="fullname">
                                        نام و نام خانوادگی
                                    </label>
                                    <input type="text" class="form-control" name="name" id="fullname">
                                </div>
                                <div class="form-group text-right">
                                    <label class="required" for="phonenumber">
                                        تلفن
                                    </label>
                                    <input type="text" class="form-control" name="phone" id="phonenumber">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group text-right">
                                    <label class="required" for="address">
                                        آدرس پستی
                                    </label>
                                    <input type="text" class="form-control" name="address" id="address">
                                </div>
                                <div class="form-group text-right">
                                    <label class="required" for="pastalcode">
                                        کد پستی
                                    </label>
                                    <input type="text" class="form-control" name="pastalcode" id="pastalcode">
                                </div>
                                <div class="form-group text-right">
                                    <label class="required" for="province">
                                        استان
                                    </label>
                                    <input type="text" class="form-control" name="province" id="province">
                                </div>
                                <div class="form-group text-right">
                                    <label class="required" for="city">
                                        شهر
                                    </label>
                                    <input type="text" class="form-control" name="city" id="city">
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <input type="checkbox" name="" id="">
                                    <label for="" class="form-check-label mr-2">
                                        استفاده به عنوان آدرس پیش فرض
                                    </label>
                                </div>
                                <div class="d-flex justify-content-start flex-column flex-md-row mt-5">
                                    <button class="btn action-btn" type="submit">ذخیره آدرس</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
