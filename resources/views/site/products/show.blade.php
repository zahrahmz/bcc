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
        <div class="row product">
            <div class="col-md-7 col-12 discount">
                @if(!empty($product->product_discount))
                    <span class="discount__badge">
                        ٪ {{ $product->product_discount }} تخفیف
                    </span>
                @endif
                <div class="fotorama"
                     data-thumbwidth="90"
                     data-thumbheight="90"
                     data-thumbborderwidth="0"
                     data-maxwidth="100%"
                     data-width="70%"
                     data-ratio="9/10"
                     data-arrows="true"
                     data-galleryrole="gallery"
                     data-thumbfit="contain"
                     data-thumbmargin="5"
                     data-nav="thumbs">
                    @foreach($product->images as $image)
                        <img src="{{ $image }}">
                    @endforeach
                </div>
            </div>
            <div class="col-md-5 col-12 position-relative">
                <div class="">
                    <h1 class="product__title">{{ $product->product_name }}</h1>
                    <div class="d-flex align-items-center product__price-wrapper">
                        <p id="price"
                           class="product__price h1">{{ $product->product_price_discount }} تومان </p>
                        @if(!empty($product->product_discount))
                            <p id="price_with_discount" class="product__old-price h1">{{ $product->price }} تومان </p>
                        @endif
                    </div>
                </div>
                <hr>
                <form class="product__options mb-3" action="{{ route('site.cart.add',['product' => $product->id]) }}"
                      method="post">
                    @csrf
                    @if(!$product->attributes->isEmpty())
                        <div class="form-row px-2 form-group">
                            <label class="col-lg-4 col-sm-3 d-none d-md-block col-form-label" for="size-select">
                                سایز
                            </label>
                            <select class="col-lg-8 col-sm-9 col-12 form-control" name="product_attribute"
                                    id="product_attribute-select">
                                <option value="-1">----</option>
                                @foreach($product->attributes as $attribute)
                                    <option
                                        value="{{ $attribute->id }}">{{ $attribute->attributesValues[0]['value'] }}</option>
                                @endforeach
                            </select>
                            @error('product_attribute')
                            <span class="validation-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-row px-2 form-group">
                        <label class="col-lg-4 col-sm-3 col-form-label d-none d-md-block"
                               for="productQuantity">تعداد</label>
                        <div class="col-lg-2 col-sm-3 col-4 d-flex quantity-input px-0">
                            <button class="border-left-0 p-0 p-lg-2 product-quantity-plus" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                            <input class="form-control text-center"
                            type="number" name="quantity" id="productQuantity"
                            min="1" value="1" readonly>
                            <button class="border-right-0 p-0 p-lg-2 product-quantity-minus" type="button">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                        <button type="button" class="btn btn-link small align-self-center mr-auto sizing-guid"
                                data-toggle="modal"
                                data-target="#sizeGuideModal">
                            راهنمای انتخاب سایز
                        </button>
                    </div>
                    @error('quantity')
                    <span class="validation-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                    <div class="modal fade" id="sizeGuideModal" tabindex="-1" role="dialog"
                         aria-labelledby="sizeGuideModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header justify-content-end">
                                    <button type="button" class="btn close-modal-btn" data-dismiss="modal"
                                            aria-label="Close">
                                        ✕
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 id="sizeGuideModalTitle">راهنمای انتخاب سایز</h2>
                                        </div>
                                        <div class="col-12">
                                            <p>برای تشخیص سایز و خرید لباس باید این نکته را در نظر داشته‌باشید که ممکن
                                                است
                                                سایزبندی
                                                هر برند یا هر کشور متفاوت باشد و هنگام انتخاب لباس و خرید آن به‌صورت
                                                اینترنتی
                                                بهتر
                                                است به جدول سایز همان برند که توسط شرکت بی سی سی در اختیارتان گذاشته
                                                می‌شود
                                                مراجعه
                                                کنید و بهترین خرید را داشته باشید که نیاز به تعویض نداشته باشد. جدول ذیل
                                                برای
                                                طرح
                                                های جدید بی سی سی می باشد.
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <img class="w-100" src="../dist/img/size-guide.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($product->attributes->isEmpty())
                        @if($product->quantity > 0)
                            <button class="btn action-btn btn-block" style="" type="submit">افزودن به سبد خرید</button>
                        @else
                            <button class="btn action-btn btn-block" style="background: red" type="submit" disabled>ناموجود</button>
                        @endif
                    @else
                        <button id="add_to_cart" class="btn action-btn btn-block"  type="submit">افزودن به سبد خرید</button>
                    @endif
                </form>
                <div class="d-flex justify-content-center">
                    <form action="{{ route('site.product.add_to_wish_list',['product' => $product->id]) }}" method="POST">
                        @csrf
                        <button class="btn center add-to-favorite d-flex align-items-center mb-3" type="submit">
                            <i class="svg-icon svg-icon-heart ml-3"></i>
                            افزودن به علاقه مندی ها
                        </button>
                    </form>

                </div>
                <div id="accordion" class="product-more-info">
                    <div class="border-top">
                        <h4 class="product-more-info__title pointer m-0" data-toggle="collapse"
                            data-target="#desCollapse" aria-expanded="true" aria-controls="desCollapse">
                            توضیحات
                            <i class="fas fa-angle-up"></i>
                        </h4>
                        <div id="desCollapse" class="collapse show" data-parent="#accordion">
                            <p class="product-more-info__text">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row my-5">
            <div class="col-md-12 mb-3">
                <h3 class="text-center">محصولات مرتبط</h3>
            </div>
            <div class="col-12">
                <div class="recommendations">
                    <div id="related-list" class="owl-carousel">
                        @foreach($similarProducts as $similarProduct)
                            <div class="d-flex flex-column recommendations__item">
                            <img class="mb-2" src="{{ $similarProduct->image }}" alt="">
                            <p>{{ $similarProduct->product_name }}</p>
                            <div class="d-flex justify-content-between pl-2">
                                <p>{{ $similarProduct->product_price_discount }} ريال</p>
                                <p v-if="{{ $similarProduct->product_discount }}" class="old-price">{{ $similarProduct->price }} ريال</p>
                            </div>
                            <span v-if="{{ $similarProduct->product_discount }}" class="recommendations__item__off-badge">{{ $similarProduct->product_discount }}% تخفیف</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $("#product_attribute-select").change(function () {
                $.get({
                    url: "/api/get-price-product-by-product-attribute/" + this.value,
                    beforeSend: function () {
                        $("#loader").addClass('loading');
                    },
                    success: function (data) {
                        console.log(data.data)
                        if(data.data.product_attribute_quantity < 1){
                            $('#add_to_cart').css("background-color", "red");
                            $('#add_to_cart').text("ناموجود");
                            $('#add_to_cart').prop('disabled', true);
                        }else{
                            $('#add_to_cart').css("background-color", "#a3cced");
                            $('#add_to_cart').text("افزودن به سبد خرید");
                            $('#add_to_cart').prop('disabled', false);
                        }

                        $("#price").text(data.data.price_with_discount + " تومان")
                        $("#price_with_discount").text(data.data.price + " تومان")

                        $("#loader").removeClass('loading');
                    },
                    error:function (xhr, ajaxOptions, thrownError) {
                        $('#add_to_cart').css("background-color", "red");
                        $('#add_to_cart').text("خطایی رخ داده!!!");
                        $('#add_to_cart').prop('disabled', true);

                        $("#loader").removeClass('loading');
                    }
                });
            });
        });
    </script>
@endpush
