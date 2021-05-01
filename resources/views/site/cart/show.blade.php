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
    @if(empty($listOfProducts))
    <div class="row">
        <div class="col-12 d-flex flex-column">
            <img class="empty-cart-image" src="..\..\resources\site\images\empty_cart.jpg" alt="empty">
            <p>سبد خرید شما خالی است.</p>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 col-md-9 cart-table">
            @if($errors->has('product_entity'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger text-right" role="alert">
                        <p class="mb-0">لطفا کالاهای ناموجود را از سبد خرید خود حذف کنید.</p>
                    </div>
                </div>
            </div>
            @endif
            <img style="display: none" src="https://bccstyle.com/uploads/inspection_quad_et_noaccreditation-min1564994247.png" alt="">
            <div class="row border-bottom d-none d-md-flex">
                <div class="col-6">
                    <p class="pr-3">محصول</p>
                </div>
                <div class="col-2">
                    <p class="text-center">تعداد</p>
                </div>
                <div class="col-2">
                    <p class="text-center">قیمت</p>
                </div>
                <div class="col-2">
                    <p class="text-center">قیمت کل با تخفیف</p>
                </div>
            </div>
            @foreach($listOfProducts as $key => $cartItem)
            <div class="row border-bottom cart-item-wrapper">
                <div class="col-12 col-md-6 product-info d-flex">
                    <a class="product-info__image" href="{{ route('site.product.show',['product' => $cartItem['product_id']]) }}">
                        <img src="{{ $cartItem['image'] }}" alt="">
                    </a>
                    <div class="product-info__details flex-grow-1">
                        <a class="product-info__title" href="">{{ $cartItem['product_name'] }}</a>
                        <span class="d-flex align-items-baseline mt-4 mt-md-5">
                            <b class="ml-2">سایز:</b>
                            {{ $cartItem['product_size'] }}
                        </span>
                    </div>
                </div>
                <div class="col-4 col-md-2 secondary d-flex align-items-start justify-content-center flex-column flex-md-row">
                    <p class="d-block d-md-none">قیمت</p>
                    <strong>
                        {{ format_number_to_currency($cartItem['product_price']) }} تومان
                    </strong>
                </div>
                <div class="col-4 col-md-2 secondary d-flex align-items-start justify-content-center flex-column flex-md-row quantity-col">
                    <p class="d-block d-md-none">تعداد</p>
                    <div class="d-flex quantity-input px-0">
                        <button class="border-left-0 p-0 p-lg-2 cart-product-quantity-plus" type="button" data-point="1" data-url="{{ url("api/cart/". $cartId ."/cartItem/". $cartItem['cartItemId'] . "/change-quantity") }}" @if(!$cartItem['has_enough_entity']) disabled @endif>
                            <i class="fas fa-plus"></i>
                        </button>
                        <input class="form-control text-center" type="number" name="quantity" id="productQuantity" min="1" value="{{ $cartItem['quantity'] }}" readonly>
                        <button class="border-right-0 p-0 p-lg-2 cart-product-quantity-minus" type="button" data-point="-1" data-url="{{ url("api/cart/". $cartId ."/cartItem/". $cartItem['cartItemId'] . "/change-quantity") }}">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-4 col-md-2 secondary d-flex align-items-start justify-content-center flex-column flex-md-row">
                    <p class="d-block d-md-none">قیمت کل</p>
                    <strong>
                        {{ format_number_to_currency($cartItem['product_price_discount']) }} تومان
                    </strong>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        @if(!$cartItem['has_enough_entity'])
                        <div class="alert alert-danger text-right mb-0 mt-4" role="alert">
                            <p class="mb-0">تعداد کالای انتخابی شما موجود نیست.</p>
                        </div>
                        @endif
                    </div>
                </div>
                <form class="cart-item-action-btns" action="{{ route('site.cart.delete',['cart' => $cartId,'cartItem' => $cartItem['cartItemId']]) }}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                    <button onclick="return confirm('آیا اطمینان دارید؟')" type="submit" class="btn"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            @endforeach
        </div>
        <div class="col-12 col-md-3">
            <div class="cart-summary p-4">
                <h4 class="cart-summary__title d-none d-md-block">خلاصه</h4>

                <button type="button" class="btn action-btn btn-block mb-0 mt-5" data-toggle="modal" data-target="#clubModal">
                    باشگاه مشتریان
                </button>

                <div class="modal fade" id="clubModal" tabindex="-1" role="dialog" aria-labelledby="clubModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form class="modal-content">
                            <div class="modal-header justify-contnet-between align-items-center">
                                <h4 class="modal-title" id="clubModalLabel">کارت باشگاه مشتریان</h4>
                                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="club-card">
                                    <div class="row justify-content-center">
                                        <img class="bg-white" src="/site/images/bcc-logo.png" alt="bcc">
                                    </div>
                                    <div class="row justify-content-center">
                                        <p class="club-card__title">
                                            Baby Clothes Center
                                        </p>
                                    </div>
                                    <div class="row justify-content-center">
                                        <p class="club-card__subtitle">
                                            Customer Club Card
                                        </p>
                                    </div>
                                    <div class="form-row justify-content-center my-3">
                                        <div class="col-9">
                                            <div class="form-row mb-3" dir="ltr">
                                                <input type="number" class="form-control col text-center" dir="ltr" autofocus>
                                                <input type="number" class="form-control col text-center" dir="ltr">
                                                <input type="number" class="form-control col text-center" dir="ltr">
                                                <input type="number" class="form-control col text-center" dir="ltr">
                                            </div>

                                            <div class="form-row align-items-center">
                                                <label class="bg-white p-2" for="">تاریخ انقضا:</label>
                                                <input type="number" class="form-control col-1" dir="ltr" name="" maxlength="2" id="expDateMonth">
                                                <span class="mx-2">/</span>
                                                <input type="number" class="form-control col-1" dir="ltr" name="" maxlength="2" id="expDateYear">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn action-btn m-0" data-dismiss="modal">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>

                <form class="py-4" action="{{ route('site.order.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group py-3 text-right">
                                <label for="shippingMethod">
                                    نحوه ی ارسال
                                    @error('shipment_id')
                                    <span class="validation-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>
                                <ul class="m-0 p-0 list-unstyled">
                                    @foreach($shipments as $shipment)
                                    <li class="d-flex address-option">
                                        <input type="radio" data-price="{{ $shipment->price }}" name="shipment_id" value="{{ $shipment->id }}" id="{{ 'shipment_' . $shipment->id }}">
                                        <label style="cursor: pointer" for="{{ 'shipment_' . $shipment->id }}">
                                            {{ $shipment->name }}
                                            ( {{ format_number_to_currency($shipment->price) }} تومان )
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group py-3 text-right">
                                <p>آدرس پستی
                                    @error('address_id')
                                    <span class="validation-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>

                                <ul class="m-0 p-0 list-unstyled">
                                    @foreach($addresses as $address)
                                    <li class="d-flex address-option">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" id="{{ 'address_'.$address->id }}">
                                        <label style="cursor: pointer" for="{{ 'address_'.$address->id }}">
                                            {{ $address->full_address }}
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>

                                <a class="center add-to-favorite d-flex align-items-center mb-3">
                                    <i class="fas fa-plus ml-3"></i>
                                    افزودن آدرس جدید
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-12">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <th class="text-right py-3">
                                            مجموع قیمت
                                        </th>
                                        <td class="py-3">
                                            {{ format_number_to_currency($totalPriceWithoutDiscount) }} تومان
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right py-3">
                                            هزینه ارسال
                                        </th>
                                        <td class="shipment-show py-3">
                                            0 تومان
                                        </td>
                                    </tr>
                                    <tr style="color: red">
                                        <th class="text-right py-3">
                                            مجموع تخفیف
                                        </th>
                                        <td class="py-3">
                                            {{ format_number_to_currency($totalDiscount) }} تومان
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right py-3">
                                            مبلغ قابل پرداخت
                                        </th>
                                        <td class="total-price py-3">
                                            {{ format_number_to_currency($totalPriceWithDiscount) }} تومان
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn action-btn w-100" type="submit">
                                ادامه فرآیند خرید
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @endsection
    @push('scripts')
    <script>
        //for calculating total price when user choose shipment method
        $(document).ready(function() {
            $(".address-option input").change(function() {
                if ($(this).is(':checked')) {
                    shipment_price = $(this).data("price")
                    $('.shipment-show').text(
                        number_format(
                            shipment_price,
                            0,
                            0,
                            ','
                        ) +
                        ' تومان'
                    )
                    $('.total-price').text(
                        number_format(
                            shipment_price + {
                                {
                                    $totalPriceWithDiscount
                                }
                            },
                            0,
                            0,
                            ','
                        ) +
                        ' تومان'
                    )
                    $('.total-discount').css('color', 'red')
                }
            });
        });
        $(document).ready(function() {});
    </script>
    @endpush
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(".cart-product-quantity-plus,.cart-product-quantity-minus").click(function() {
                let selector = $(this)
                let quantity = $(this).attr("data-point")
                let quantitInput = $(this).siblings('input');
                $.post({
                    data: {
                        quantity: quantity
                    },
                    url: $(this).attr("data-url"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $("#loader").addClass('loading');
                    },
                    success: function(data) {
                        console.log(data)
                        $("#loader").removeClass('loading');

                        let currentVal = parseInt(quantitInput.val(), 10) + parseInt(quantity);
                        quantitInput.val(currentVal);

                        if (0 < currentVal && currentVal < 11) {
                            console.log(0 < currentVal < 11)
                            selector.hasClass('product-quantity-plus') && selector.prop('disabled', false)
                            selector.hasClass('product-quantity-minus') && selector.prop('disabled', false)
                        } else {
                            if (selector.hasClass('product-quantity-minus')) {
                                selector.prop('disabled', true)
                            }
                            if (selector.hasClass('product-quantity-plus')) {
                                selector.prop('disabled', true)
                            }

                        }


                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $("#loader").removeClass('loading');

                    }
                });
            });
        });
    </script>
    @endpush