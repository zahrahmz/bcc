@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">
                    با ما در تماس باشید
                </h1>
            </div>
            <div class="col-12 col-md-5 mb-5">
                <form class="contact-us-form" action="">
                    <h4 class="register-form__title">
                        برای ما پیام بگذارید
                    </h4>
                    <div class="form-row">
                        <div class="col-12 form-group text-right">
                            <label for="contact-name">
                                نام و نام خانوادگی
                            </label>
                            <input type="text" class="form-control" name="name" id="contact-name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-6 form-group text-right">
                            <label for="contact-email">
                                ایمیل
                            </label>
                            <input type="email" class="form-control" name="email" id="contact-email">
                        </div>
                        <div class="col-12 col-md-6 form-group text-right">
                            <label for="contact-phone">
                                شماره تماس
                            </label>
                            <input type="tel" class="form-control" name="phone" id="contact-phone">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 form-group text-right">
                            <label for="contact-msg">
                                پیام
                            </label>
                            <textarea class="form-control" name="msg" id="contact-msg" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="form-row flex-column flex-sm-row">
                        <button class="btn action-btn" type="submit">
                            ارسال
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-7">
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="register-form__title">
                            نشانی محل شرکت
                        </h4>
                        <p>
                            تهران - خیابان ولیعصر - خیابان لبافی نژاد - کوچه زحل - کوچه مهاجر - پلاک ۱
                            شماره تماس ۶۶۹۶۲۹۵۷-۰۲۱
                        </p>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="register-form__title">
                            کارخانه
                        </h4>
                        <p>
                            شهر قدس - بلوار مصلی - روبروی تامین اجتماعی - پلاک ۸ شماره تماس ۴۶۸۲۲۷۸۸-۰۲۱
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6 d-flex">
                        <h4 class="register-form__title">
                            شماره تماس
                        </h4>
                        <p>
                            ۶۶۹۶۲۹۵۷-۸
                        </p>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <h4 class="register-form__title">
                            ایمیل
                        </h4>
                        <p>
                            info@bccstyle.com
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="locationMap" style="height: 360px"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(() => {
            let map = new L.Map('locationMap', {
                key: 'web.f2keDRcqhiPMFDO9dS4qbSLsEiz93ePPeT4etCMT',
                maptype: 'standard-day',
                poi: true,
                center: [35.69746, 51.40123],
                zoom: 14
            });
            L.marker([35.69746, 51.40123]).addTo(map);
        });
    </script>
@endpush
