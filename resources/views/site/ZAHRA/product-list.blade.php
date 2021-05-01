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
            <div class="col-12">
                <h1 class="page-title">
                    کودک
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="active-filters d-none d-md-block">
                    <div class="d-flex justify-content-between py-2 px-3">
                        <p>فیلترها</p>
                        <button class="btn">
                            حذف همه
                        </button>
                    </div>
                    <ol>
                        <li class="active-filters__item d-flex mt-3">
                            <p class="active-filters__item__label">جنسیت</p>
                            <p class="flex-grow-1 mr-2">دختر</p>
                            <button class="btn remove-filter p-0">
                                <b>✕</b>
                            </button>
                        </li>
                    </ol>
                </div>
                <div class="filters-wrapper">
                    <button class="btn action-btn show-filters-btn d-md-none d-flex justify-content-between align-items-baseline"
                            id="mobileShowFilters">
                        فیلتر
                        <i class="fas fa-angle-up"></i>
                    </button>
                    <div id="filters" class="product-filter">
                        <div class="border-bottom">
                            <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                data-target="#categoryFilter" aria-expanded="false" aria-controls="categoryFilter">
                                دسته بندی
                                <i class="fas fa-angle-up"></i>
                            </h4>
                            <div id="categoryFilter" class="collapse" data-parent="#filters">
                                <form action="">
                                    <ul class="list-unstyled my-3">
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="radio" id="filterToddler" name="category">
                                            <label for="filterToddler" class="mb-0 mr-3">کودک</label>
                                        </li>
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="radio" id="filterBaby" name="category">
                                            <label for="filterBaby" class="mb-0 mr-3">نوزاد</label>
                                        </li>
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="radio" id="filterShoes" name="category">
                                            <label for="filterShoes" class="mb-0 mr-3">کفش</label>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <div class="border-bottom">
                            <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                data-target="#genderFilter" aria-expanded="false" aria-controls="genderFilter">
                                جنسیت
                                <i class="fas fa-angle-up"></i>
                            </h4>
                            <div id="genderFilter" class="collapse" data-parent="#filters">
                                <form action="">
                                    <ul class="list-unstyled my-3">
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="checkbox" id="filterUnisex" name="gender">
                                            <label for="filterToddler" class="mb-0 mr-3">بدون جنسیت</label>
                                        </li>
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="checkbox" id="filterGirl" name="gender">
                                            <label for="filterBaby" class="mb-0 mr-3">دختر</label>
                                        </li>
                                        <li class="d-flex align-items-center mt-3">
                                            <input type="checkbox" id="filterBoy" name="gender">
                                            <label for="filterShoes" class="mb-0 mr-3">پسر</label>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <div class="border-bottom">
                            <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                data-target="#sizeFilter" aria-expanded="false" aria-controls="sizeFilter">
                                سایز
                                <i class="fas fa-angle-up"></i>
                            </h4>
                            <div id="sizeFilter" class="collapse" data-parent="#filters">
                                <p class="">
                                    3
                                </p>
                            </div>
                        </div>
                        <div class="border-bottom">
                            <h4 class="pointer m-0 product-filter__item collapsed" data-toggle="collapse"
                                data-target="#colorFilter" aria-expanded="false" aria-controls="colorFilter">
                                رنگ
                                <i class="fas fa-angle-up"></i>
                            </h4>
                            <div id="colorFilter" class="collapse" data-parent="#filters">
                                <p class="">
                                    4
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col-md-7 col-lg-8 d-none d-md-block">
                        <div class="p-1 d-flex border-bottom w-100">
                            <strong class="product-list__quantity">
                                30 محصول
                            </strong>
                        </div>
                    </div>
                    <div class="col-10 col-md-5 col-lg-4">
                        <form class="d-flex align-items-center sort-products">
                            <label class="mb-0" for="sortOptions">
                                مرتب سازی
                            </label>
                            <select class="flex-grow-1 form-control" name="sort-products" id="sortOptions">
                                <option value="">قیمت</option>
                            </select>
                            <button class="btn sort-order-btn" type="button">
                                <i class="fas fa-long-arrow-alt-down"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        <div class="col-6 col-md-4 my-3">
                            <div class="product-list__item">
                                <a href="" class="d-flex flex-column text-decoration-none">
                                    <img class="product-list__item__image"
                                         src="https://www.babycottons.com/media/catalog/product/cache/65c6d32641a857e20f42c0dce74521f7/3/3/3302_babycottons_1200011177_xx_1_7.jpg"
                                         alt="">
                                    <div class="px-3 pt-3">
                                        <p class="product-list__item__title">لورم ایپسوم متن ساختگی با تولید</p>
                                        <p class="product-list__item__price">120000 تومان</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 my-3">
                            <div class="product-list__item">
                                <a href="" class="d-flex flex-column text-decoration-none">
                                    <img class="product-list__item__image"
                                         src="https://www.babycottons.com/media/catalog/product/cache/65c6d32641a857e20f42c0dce74521f7/3/3/3302_babycottons_1200011177_xx_1_7.jpg"
                                         alt="">
                                    <div class="px-3 pt-3">
                                        <p class="product-list__item__title">لورم ایپسوم متن ساختگی با تولید</p>
                                        <p class="product-list__item__price">120000 تومان</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 my-3">
                            <div class="product-list__item">
                                <a href="" class="d-flex flex-column text-decoration-none">
                                    <img class="product-list__item__image"
                                         src="https://www.babycottons.com/media/catalog/product/cache/65c6d32641a857e20f42c0dce74521f7/3/3/3302_babycottons_1200011177_xx_1_7.jpg"
                                         alt="">
                                    <div class="px-3 pt-3">
                                        <p class="product-list__item__title">لورم ایپسوم متن ساختگی با تولید</p>
                                        <p class="product-list__item__price">120000 تومان</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 my-3">
                            <div class="product-list__item">
                                <a href="" class="d-flex flex-column text-decoration-none">
                                    <img class="product-list__item__image"
                                         src="https://www.babycottons.com/media/catalog/product/cache/65c6d32641a857e20f42c0dce74521f7/3/3/3302_babycottons_1200011177_xx_1_7.jpg"
                                         alt="">
                                    <div class="px-3 pt-3">
                                        <p class="product-list__item__title">لورم ایپسوم متن ساختگی با تولید</p>
                                        <p class="product-list__item__price">120000 تومان</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 my-3">
                            <div class="product-list__item">
                                <a href="" class="d-flex flex-column text-decoration-none">
                                    <img class="product-list__item__image"
                                         src="https://www.babycottons.com/media/catalog/product/cache/65c6d32641a857e20f42c0dce74521f7/3/3/3302_babycottons_1200011177_xx_1_7.jpg"
                                         alt="">
                                    <div class="px-3 pt-3">
                                        <p class="product-list__item__title">لورم ایپسوم متن ساختگی با تولید</p>
                                        <p class="product-list__item__price">120000 تومان</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
