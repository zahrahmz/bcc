@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><a href="#">خانه</a></li>
                        <li class="breadcrumb-item active" aria-current="page">محصولات</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="active-filters d-none d-md-block">
                    <div class="d-flex justify-content-between py-2 px-3">
                        <p>فیلترها</p>
                    </div>
                </div>
                <div class="filters-wrapper">
                    <button
                        class="btn action-btn show-filters-btn d-md-none d-flex justify-content-between align-items-baseline"
                        id="mobileShowFilters">
                        فیلتر
                        <i class="fas fa-angle-up"></i>
                    </button>
                    <div id="filters" class="product-filter">
                        <form class="form_filter" action="{{ route('site.product.index') }}" method="get">
                            <div class="border-bottom">
                                <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                    data-target="#categoryFilter" aria-expanded="false" aria-controls="categoryFilter">
                                    دسته بندی
                                    <i class="fas fa-angle-up"></i>
                                </h4>
                                <div id="categoryFilter" class="collapse" data-parent="#filters">
                                    <ul class="list-unstyled my-3">
                                        @foreach($categories as $key => $category)
                                            <li class="d-flex align-items-center mt-3">
                                                <input @if($key == $data['category']) checked
                                                       @endif class="on_change_submit" type="radio" id="{{ "category_" . $key }}"
                                                       name="category"
                                                       value="{{ $key }}">
                                                <label for="{{ "category_" . $key }}" class="mb-0 mr-3">{{ $category }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="border-bottom">
                                <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                    data-target="#genderFilter" aria-expanded="false" aria-controls="genderFilter">
                                    جنسیت
                                    <i class="fas fa-angle-up"></i>
                                </h4>
                                <div id="genderFilter" class="collapse" data-parent="#filters">
                                    <ul class="list-unstyled my-3">
                                        @foreach(\App\Models\Product::GENDER as $key => $gender)
                                            <li class="d-flex align-items-center mt-3">
                                                <input @if(in_array($key,$data['gender'])) checked
                                                       @endif class="on_change_submit" type="checkbox"
                                                       id="{{"gender".$key}}" name="gender[]" value="{{ $key }}">
                                                <label for="{{"gender".$key}}" class="mb-0 mr-3">{{ $gender }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="border-bottom">
                                <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                    data-target="#sizeFilter" aria-expanded="false" aria-controls="sizeFilter">
                                    سایز
                                    <i class="fas fa-angle-up"></i>
                                </h4>
                                <div id="sizeFilter" class="collapse" data-parent="#filters">
                                    <ul class="list-unstyled my-3">
                                        {{-- we only get first row of attribute,first row is `size`.
                                        if in the future want to add more attribute we need to writing more code and extend current code--}}
                                        @foreach($attributes->first()->values as $eachValue)
                                            <li class="d-flex align-items-center mt-3">
                                                <input class="on_change_submit" id="{{ "size_" . $eachValue->id }}"
                                                       @if(in_array($eachValue->id,$data['size'])) checked @endif
                                                       type="checkbox" name="size[]"
                                                       value="{{ $eachValue->id }}">
                                                <label for="{{ "size_" . $eachValue->id }}"
                                                       class="mb-0 mr-3">{{ $eachValue->value }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="border-bottom">
                                <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                    data-target="#colorFilter" aria-expanded="false" aria-controls="colorFilter">
                                    طرح
                                    <i class="fas fa-angle-up"></i>
                                </h4>
                                <div id="colorFilter" class="collapse" data-parent="#filters">
                                    @foreach($brands as $key => $brand)
                                        <li class="d-flex align-items-center mt-3">
                                            <input class="on_change_submit" @if(in_array($key,$data['brand'])) checked
                                                   @endif type="checkbox" id="{{"brand_".$key}}" name="brand[]"
                                                   value="{{ $key }}">
                                            <label for="{{"brand_".$key}}" class="mb-0 mr-3">{{ $brand }}</label>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col-md-7 col-lg-8 d-none d-md-block">
                        <div class="p-1 d-flex border-bottom w-100">
                            <strong class="product-list__quantity">
                                {{ $products->total() }} محصول
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-6 col-md-4 my-3">
                                <div class="product-list__item h-100 discount">
                                    @if($product->product_discount)
                                        <span class="discount__badge">
                                            {{$product->product_discount}} % تخفیف
                                        </span>
                                    @endif
                                    <a href="/product/{{$product->id}}" class="d-flex flex-column h-100 text-decoration-none">
                                        <img class="product-list__item__image"
                                             src="{{ $product->image }}"
                                             alt="">
                                        <div class="px-3 pt-3">
                                            @if($product->attributes()->sum('quantity') < 1)
                                                <div class="price-item " style="text-align: center">
                                                    <p class="product-list__item__title">{{ $product->product_name }}</p>
                                                    <span class="price"
                                                          style="color: #ababab;font-size: 1.286rem;line-height: 1.222;font-weight: 400;margin-top: 20px;"> ـــــــــــــــــــــ  ناموجود   ــــــــــــــــــــــ</span>
                                                </div>
                                            @else
                                                <p class="product-list__item__title">{{ $product->product_name }}</p>
                                                <p class="product-list__item__price">{{ $product->product_price_discount }} تومان</p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if($products->isNotEmpty())
                <div class="row justify-content-start">
                    <input type="hidden" id="next_page" value="2">
                    <button id="btn" class="action-btn">
                        محصولات بیشتر...
                    </button>
                </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        //apply filters
        $(function () {
            $(".on_change_submit").change(function () {
                $(".form_filter").submit();
            });
        });


        $(document).ready(function () {
            //load more products through pagination
            $("#btn").click(function () {
                var products = ''
                $("#loader").addClass('loading');
                    var current_url = window.location.href // load current url with all filters
                    $.ajax({
                        url: current_url,
                        type: "get",
                        data: {
                            page: $('#next_page').val(),
                            api: true,
                        },
                        success: function (response) {
                            //if response hasn't any product than we prevent to send more request
                            if (response.data.current_page >= response.data.last_page){
                                $('#btn').hide()
                            }
                            $("#loader").removeClass('loading');
                            var new_page = parseInt($('#next_page').val()) + 1 //calculate current next page and convert it to integer
                            $('#next_page').val(new_page) //set next page to hidden input
                            $.each(response.data.data, function (k, product) {
                                //html of one product
                                var one_product =
                                    '<div class="col-6 col-md-4 my-3">' +
                                    '<div class="product-list__item discount">' +
                                    '<a href="$productLink" class="d-flex flex-column text-decoration-none">' +
                                    '$productDiscountHtml' +
                                    '<img class="product-list__item__image" src="$productImage"  alt="">' +
                                    '<div class="px-3 pt-3">' +
                                    '<p class="product-list__item__title">$productTitle</p>' +
                                    '<p class="product-list__item__price">$productPrice</p>' +
                                    '</div>' +
                                    '</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'


                                var discountHtml =
                                    '<span class="discount__badge">' +
                                    '$productDiscount' +
                                    '</span>'

                                if (product.image){
                                    var product_image = product.image.path
                                }

                                //load product image path


                                //replace html with dynamic data
                                one_product = one_product.replace('$productPrice', product.price)
                                one_product = one_product.replace('$productLink', '/product/' + product.id)
                                one_product = one_product.replace('$productImage', product_image)
                                one_product = one_product.replace('$productTitle', product.product_name)
                                if (product.product_discount){
                                    one_product = one_product.replace('$productDiscountHtml', discountHtml )
                                    one_product = one_product.replace('$productDiscount', product.product_discount + '  % تخفیف')
                                }
                                one_product = one_product.replace('$productDiscountHtml', '')


                                //attach all loaded product from ajax call
                                products += one_product
                            });

                            //append loaded products to html dom
                            $(".product-list .row").append(products);


                        },
                        error: function (xhr) {
                        }
                    });
            });
        });
    </script>
@endpush
