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
                            <form action="{{ route('admin.products.store') }}" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('products.product_name') }}</label>
                                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}"
                                                   placeholder="{{ trans('products.product_name') }}">
                                            @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.sku') }}</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{ old('sku') }}" placeholder="{{ trans('products.sku') }}">
                                            @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.slug') }}</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" placeholder="{{ trans('products.slug') }}">
                                            @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.description') }}</label>
                                            <textarea  class="form-control @error('description') is-invalid @enderror" name="description"
                                                       placeholder="{{ trans('products.description') }}">{{ old('description') }}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.price') }}</label>
                                            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"  value="{{ old('price') }}" placeholder="{{ trans('products.price') }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>جنسیت</label>
                                            <select class="form-control select2 select2-hidden-accessible  @error('gender') is-invalid @enderror" name="gender"  data-placeholder="نوع جنسیت را مشخص کنید" style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true">
                                                <option value="-1">----</option>
                                                @foreach(\App\Models\Product::GENDER as $key => $value)
                                                    <option @if($key == old('gender')) selected @endif value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status" checked>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status">
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>دسته بندی</label>
                                            <select class="form-control select2 select2-hidden-accessible @error('categories') is-invalid @enderror" name="categories[]" multiple="" data-placeholder="یک دسته بندی انتخاب کنید" style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true">
                                                @foreach($categories as $category)
                                                <option @if(in_array($category->id,old('categories') ?? [])) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('categories')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input @if(old('featured')) checked @endif name="featured" type="checkbox" class="flat-red">
                                                محصول ویژه
                                            </label>
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
            $('.select2').select2()
        })

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
    </script>
@endpush
