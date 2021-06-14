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
                                ویرایش اطلاعات حساب کاربری
                            </h1>
                        </div>
                    </div>
                    <form class="row edit-info-form">
                        <fieldset class="col-12 col-md-6 mb-5">
                            <div class="form-row">
                                <h2 class="mb-5">
                                    اطلاعات حساب کاربری
                                </h2>
                            </div>
                            <div class="form-group text-right">
                                <label for="firstName" class="required">
                                    نام
                                </label>
                                <input type="text" id="firstName" class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <label for="lastName" class="required">
                                    نام خانوادگی
                                </label>
                                <input type="text" id="lastName" class="form-control">
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <input type="checkbox" name="" id="">
                                <label for="" class="form-check-label mr-2">تغییر ایمیل</label>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <input type="checkbox" name="" id="">
                                <label for="" class="form-check-label mr-2">تغییر رمز عبور</label>
                            </div>
                            <div class="form-group text-right">
                                <label for="telephone">
                                    تلفن
                                </label>
                                <input type="text" id="telephone" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset class="col-12 col-md-6 mb-5">
                            <div class="form-row">
                                <h2 class="mb-5">
                                    تغییر ایمیل و رمز عبور
                                </h2>
                            </div>
                            <div class="form-group text-right">
                                <label for="email" class="required">
                                    ایمیل
                                </label>
                                <input type="email" id="email" class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <label for="password" class="required">
                                    رمز عبور فعلی
                                </label>
                                <input type="password" id="password" class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <label for="newPassword" class="required">
                                    رمز عبور جدید
                                </label>
                                <input type="password" id="newPassword" class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <label for="newPasswordRepeat" class="required">
                                    تکرار رمز عبور جدید
                                </label>
                                <input type="password" id="newPasswordRepeat" class="form-control">
                            </div>
                        </fieldset>
                        <div class="col-12 form-row">
                            <button type="submit" class="btn action-btn">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
