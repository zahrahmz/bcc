@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">اطلاعات محصول</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('admin.addresses.store',$user->id) }}" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>نام استان</label>
                                            <select id="province"  class="form-control select2 select2-hidden-accessible @error('province') is-invalid @enderror" name="province"  data-placeholder="یک استان انتخاب کنید" style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true">
                                                <option value="-1"> ----- </option>
                                                @foreach($provinces as $provinceId =>  $provinceName)
                                                    <option data-province="{{$provinceId}}" value="{{ $provinceName }}">{{ $provinceName }}</option>
                                                @endforeach
                                            </select>
                                            @error('province')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>نام شهر</label>
                                            <select disabled id="city" class="form-control select2 select2-hidden-accessible @error('city') is-invalid @enderror" name="city"  data-placeholder="یک شهر انتخاب کنید" style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true">                                            </select>
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>کد پستی</label>
                                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" placeholder="کد پستی">
                                            @error('postal_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>نام تحویل گیرنده</label>
                                            <input type="text" class="form-control @error('name_of_receiver') is-invalid @enderror" name="name_of_receiver" value="{{ old('name_of_receiver') }}" placeholder="نام تحویل گیرنده">
                                            @error('name_of_receiver')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>موبایل تحویل گیرنده</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                </div>
                                                <input type="text" id="phone" class="form-control ltr  @error('phone') is-invalid @enderror"  name="phone" value="{{ old('phone') }}" data-mask="">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>آدرس</label>
                                            <textarea  class="form-control @error('address') is-invalid @enderror" name="address"
                                                       placeholder="آدرس">{{ old('address') }}</textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.products.index')}}">{{ trans('main.back') }}
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
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
    <script>
        $(document).ready(function(){
            $("#province").change(function(){
                $.get("/api/get-city-of-province/" + $('option:selected', this).data('province'), function(data, status){
                    cities = ''
                    $.each( data, function( key, value ) {
                        cities +=  '<option value=' + value
                        cities +=  '>'
                        cities +=  value
                        cities +=  '</option>'
                    });
                    $("#city").html(cities)
                    $( "#city" ).prop( "disabled", false )
                });
            });
        });
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('#phone').inputmask("0\\9**-***-****",{
                placeholder:"*",
                clearMaskOnLostFocus: false
            });
        })
    </script>
@endpush
