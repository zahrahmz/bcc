@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">
                    آدرس شعب
                </h1>
            </div>
            <div class="col-12">
                <div class="row flex-row-reverse flex-md-row">
                    <div class="col-12 col-md-4">
                        <div class="scroll-list px-4 overflow-auto" style="max-height: 620px">
                            <div class="store-branch pointer p-2 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه میرداماد
                                </h4>
                                <p class="store-branch__address">
                                    خیابان میرداماد خیابان شاه نظری نبش کوچه دوم پلاک ۳۲
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۲۲۷۲۵۵۰
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه ارگ
                                </h4>
                                <p class="store-branch__address">
                                    میدان تجریش، خیابان سعدآباد، مجتمع تجاری ارگ، طبقه همکف، واحد ۲۱۴
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۲۳۹۶۵۳۰
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه ميلاد نور
                                </h4>
                                <p class="store-branch__address">
                                    شهرك غرب مجتمع ميلادنور همكف يك واحد ۴۴
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۸۸۰۸۵۰۲۶
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه ايران مال
                                </h4>
                                <p class="store-branch__address">
                                    به زودي
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۵۷۱۴۰۰۰
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه شاپرک
                                </h4>
                                <p class="store-branch__address">
                                    اتوبان رسالت، مجتمع مادر و کودک شاپرک، طبقه اول، واحد ۳۴
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۲۲۷۲۵۵۰
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه میرداماد
                                </h4>
                                <p class="store-branch__address">
                                    میدان تجریش، خیابان سعدآباد، مجتمع تجاری ارگ، طبقه همکف، واحد ۲۱۴
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۲۲۷۲۵۵۰
                                </a>
                            </div>
                            <div class="store-branch pointer px-4 d-flex flex-column justify-content-center">
                                <h4 class="store-branch__name active">
                                    شعبه میرداماد
                                </h4>
                                <p class="store-branch__address">
                                    میدان تجریش، خیابان سعدآباد، مجتمع تجاری ارگ، طبقه همکف، واحد ۲۱۴
                                </p>
                                <a href="tel:۰۲۱۲۲۲۷۲۵۵۰" class="store-branch__tel">
                                    تلفن:
                                    ۰۲۱۲۲۲۷۲۵۵۰
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div id="storeMap" style="height: 620px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(() => {
            const branchesLocation = [
                [35.75777, 51.44259],
                [35.80804, 51.44645],
                [35.69746, 51.40123],
                [35.69746, 52.40123]
            ];
            let store = new L.Map('storeMap', {
                key: 'web.f2keDRcqhiPMFDO9dS4qbSLsEiz93ePPeT4etCMT',
                maptype: 'standard-day',
                poi: true,
                center: [35.75777, 51.44251],
                zoom: 14
            });
            branchesLocation.forEach(item => {
                L.marker(new L.LatLng(...item)).addTo(store);
            })

            $('.store-branch').on('click', (event) => {
                $('.store-branch').each((i, e) => {
                    if ($(e).hasClass('active')) {
                        $(e).removeClass('active');
                    }
                })
                $(event.currentTarget).addClass('active');
                let index = $('.store-branch').index($(event.currentTarget));
                store.flyTo(new L.LatLng(...branchesLocation[index]));
            })
        });
    </script>
@endpush
