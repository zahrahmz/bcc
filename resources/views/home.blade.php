@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        @if(!empty($slides = $sliders[\App\Models\Slider::HOME_TOP]))
            <div class="row mb-5">
                <div id="mainPageSlider" class="carousel slide col-12" data-ride="carousel" style="max-height:555px">
                    <ul class="carousel-indicators">
                        @foreach($slides as $key =>  $slide)
                            <li data-target="#mainPageSlider" data-slide-to="{{ $key }}" class="@if($key == 0)active @endif"></li>
                        @endforeach
                    </ul>
                    <div class="carousel-inner h-100">
                        @foreach($slides as $key =>  $slide)
                            <a href="{{$slide['link']}}" class="carousel-item h-100 @if($key == 0) active @endif" target="_blank">
                                <img class="d-block w-100" src="{{ $slide['image'] }}" alt="First slide">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="row mb-5">
            <div class="col-12 mb-2 d-flex justify-content-center mb-3">
                <h3>
                    محبوبترین ها
                </h3>
            </div>
            <div class="col-12 mb-2">
                <div class="favorites">
                            <div id="recommendations-list" class="owl-carousel">
                    @if($featuredProducts->isNotEmpty())
                        @foreach($featuredProducts as $featuredProduct)
                                <div class="d-flex flex-column recommendations__item">
                                    @if($featuredProduct->image)
                                        <a href="/product/{{$featuredProduct->id}}" target="_blank">
                                            <img class="mb-2" src="{{ $featuredProduct->image }}" alt="">
                                        </a>
                                    @endif
                                    <p>{{$featuredProduct->product_name}}</p>
                                    <div class="d-flex justify-content-between pl-2">
                                        @if($featuredProduct->product_discount)
                                            <p>{{$featuredProduct->product_price_discount}}  تومان </p>
                                        @endif
                                        <p class="@if(!$featuredProduct->discount)d-flex justify-content-between pl-2 @else old-price @endif">{{$featuredProduct->price}} ريال</p>
                                    </div>
                                    @if($featuredProduct->product_discount)
                                    <span class="recommendations__item__off-badge">{{$featuredProduct->product_discount}}% تخفیف</span>
                                    @endif
                                </div>

                        @endforeach
                    @endif
                            </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button class="btn action-btn">
                    خرید
                </button>
            </div>
        </div>
        @if(!empty($slides = $sliders[\App\Models\Slider::HOME_MIDDLE]))
            <div class="row mb-5">
                @foreach($slides as $slide)
                <a class="col-12 col-md-6 mb-3 mb-md-0" href="{{$slide['link']}}">
                    <img class="mw-100"
                         src="{{ $slide['image'] }}"
                         width="800"
                         height="500"
                         alt="">
                </a>
                @endforeach
            </div>
        @endif
        <div class="row mb-5">
            <div class="col-12 mb-2 d-flex justify-content-center mb-3">
                <h3>
                    طرح های البسه
                </h3>
            </div>
            <div class="col-12 mb-2">
                <div class="favorites">
                    <div id="patterns-list" class="owl-carousel patterns-list">
                        @foreach($brands as $brand)
                        <div class="d-flex justify-content-center patterns-list__item">
                            @if($brand->image)
                                <img src="{{ $brand->image }}" alt="">
                                <a class="patterns-list__item__title" href="">{{$brand->name}}</a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
