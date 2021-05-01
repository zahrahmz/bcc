@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('admin.discount.store') }}" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('discount.title') }}</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   name="title" value="{{ old('title') }}"
                                                   placeholder="{{ trans('discount.title') }}">
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label>{{ trans('discount.percent') }}</label>
                                            <input type="number"
                                                   class="form-control @error('percent') is-invalid @enderror"
                                                   name="percent" value="{{ old('percent') }}"
                                                   placeholder="{{ trans('discount.percent') }}" min="1" max="100">
                                            @error('percent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('discount.type') }}</label>
                                            <select class="form-control select2 select2-hidden-accessible "
                                                    id="type-select" style="width: 100%;text-align: right" tabindex="-1"
                                                    aria-hidden="true" name="type">
                                                <option value="">یک گزینه را انتخاب کنید</option>
                                                @foreach(\App\Models\Discount::DISCOUNTABLE_TYPES as $key => $discountableType)
                                                    <option value="{{ $discountableType }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group" style="display: none" id="product_id">
                                            <label for="parent_id">محصولات</label>
                                            <select class="form-control select2 select2-hidden-accessible" multiple=""
                                                    style=" width: 100%;text-align: right" tabindex="-1"
                                                    aria-hidden="true" name="discountable_id[]">
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">
                                                        {{$product->product_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group" style="display: none" id="category_id">
                                            <label for="parent_id">برندها</label>
                                            <select class="form-control select2 select2-hidden-accessible" multiple=""
                                                    style="width: 100%;text-align: right" tabindex="-1"
                                                    aria-hidden="true" name="discountable_id[]">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">
                                                        {{$category->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('discount.start_date') }}</label>
                                            <input type="text"
                                                   class="date-picker-start form-control @error('start_date') is-invalid @enderror"
                                                   name="start_date" value="{{ old('start_date') }} " autocomplete="off"
                                                   placeholder="{{ trans('discount.start_date') }}">
                                            @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('discount.end_date') }}</label>
                                            <input type="text"
                                                   class="date-picker-end form-control @error('end_date') is-invalid @enderror"
                                                   name="end_date" value="{{ old('end_date') }}" autocomplete="off"
                                                   placeholder="{{ trans('discount.end_date') }}">

                                            @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status"
                                                       checked>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status">
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-12">
                                        <button type="submit"
                                                class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info"
                                           href="{{route('admin.discount.index')}}">{{ trans('main.back') }}
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col -->
    </div>

@endsection()

@push('scripts')

    <script src= {{ asset('admin/js/persian-date.min.js') }}></script>
    <script src= {{ asset('admin/js/persian-datepicker.min.js') }}></script>

    <script>
        $(function () {
            $('#type-select').on('change', function () {
                var el = $('#type-select').val();
                if (el == "App\\Models\\Category") {
                    document.getElementById("product_id").style.display = "none";
                    document.getElementById("category_id").style.display = "block";
                } else if (el == "App\\Models\\Product") {
                    document.getElementById("category_id").style.display = "none";
                    document.getElementById("product_id").style.display = "block";

                }
            });
        })


    </script>
    <script type="text/javascript">

        $(".date-picker-start").persianDatepicker({
            initialValue: false,
            format: 'YYYY/MM/DD',
            autoClose: true,
            calendar: {
                persian: {
                    locale: 'en'
                }
            }

        });

        $(".date-picker-end").persianDatepicker({
            initialValue: false,
            format: 'YYYY/MM/DD',
            autoClose: true,
            calendar: {
                persian: {
                    locale: 'en'
                }
            }

        });


    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2({})
        })
    </script>
@endpush

