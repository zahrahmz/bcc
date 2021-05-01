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
                            <form action="{{ route('admin.categories.store') }}" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('categories.category_name') }}</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                                                   placeholder="{{ trans('categories.name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('categories.order') }}</label>
                                            <input type="text" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') }}" placeholder="{{ trans('categories.order') }}">
                                            @error('order')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('categories.slug') }}</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" placeholder="{{ trans('categories.slug') }}">
                                            @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
{{--                                        <div class="form-group">--}}
{{--                                            <label>{{ trans('categories.description') }}</label>--}}
{{--                                            <textarea  class="form-control @error('description') is-invalid @enderror" name="description"--}}
{{--                                                       placeholder="{{ trans('categories.description') }}">{{ old('description') }}</textarea>--}}
{{--                                            @error('description')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                                <strong>{{ $message }}</strong>--}}
{{--                                            </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
                                        <div class="form-group">
                                            <label>{{ trans('categories.type') }}</label>
                                            <select class="form-control select2 select2-hidden-accessible"  style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true" name="type">
                                                <option value="{{\App\Models\Category::MENU}}">منو</option>
                                                <option value="{{\App\Models\Category::CATEGORY}}">دسته بندی</option>
                                                <option value="{{\App\Models\Category::BRAND}}">برند </option>
                                            </select>
                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="parent_id">{{ trans('categories.parent_id') }}</label>
                                            <select class="form-control select2 select2-hidden-accessible"  style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true" name="parent_id">
                                                <option value="">بدون دسته بندی والد</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}">
                                                        {{$cat->name}}
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
                                            <label>{{ trans('categories.link') }}</label>
                                            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"  value="{{ old('link') }}" placeholder="{{ trans('categories.link') }}">
                                            @error('link')
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


                                    <div class="col-md-12">
                                        <button type="submit" class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.categories.index')}}">{{ trans('main.back') }}
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
            $('.select2').select2({

            })
        })
    </script>
@endpush
