@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @php($tab = session()->get('tab'))
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header d-flex p-0">

                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a
                                class="nav-link @if(empty($tab)) active @elseif($tab == 'category_attribute') active @endif"
                                href="#tab_1" data-toggle="tab">اطلاعات
                            دسته بندی</a></li>
                    <li class="nav-item"><a class="nav-link @if($tab == 'category_images') active @endif"
                                            href="#tab_2" data-toggle="tab">عکس دسته بندی </a></li>
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane  @if(empty($tab)) active @elseif($tab == 'category_attribute') active @endif"
                             id="tab_1">
                            <form action="{{ route('admin.categories.update',$category->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('categories.category_name') }}</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name" value="{{ $category->name }}"
                                                   placeholder="{{ trans('categories.category_name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('categories.order') }}</label>
                                            <input type="text" class="form-control @error('order') is-invalid @enderror"
                                                   name="order" value="{{ $category->order }}"
                                                   placeholder="{{ trans('categories.order') }}">
                                            @error('order')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('categories.slug') }}</label>
                                            <input type="text"
                                                   class="form-control @error('slug') is-invalid @enderror"
                                                   name="slug" value="{{ $category->slug }}"
                                                   placeholder="{{ trans('categories.slug') }}">
                                            @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('categories.description') }}</label>
                                            <input type="text"
                                                   class="form-control @error('description') is-invalid @enderror"
                                                   name="description" value="{{ $category->description }}"
                                                   placeholder="{{ trans('categories.description') }}">
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('categories.type') }}</label>
                                            <select class="form-control select2 select2-hidden-accessible"  style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true" name="type">
                                                <option {{$category->type == "منو" ? 'selected' : ''}} value="{{\App\Models\Category::MENU}}" >منو</option>
                                                <option {{$category->type == "دسته بندی" ? 'selected' : ''}} value="{{\App\Models\Category::CATEGORY}}" >دسته بندی</option>
                                                <option {{$category->type == "برند" ? 'selected' : ''}} value="{{\App\Models\Category::BRAND}}" > برند </option>
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
                                                    <option {{$category->parent_id === $cat->id ? 'selected' : ''}} value="{{$cat->id}}">
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
                                            <input type="text" class="form-control @error('link') is-invalid @enderror"
                                                   name="link" value="{{ $category->link }}"
                                                   placeholder="{{ trans('categories.link') }}">
                                            @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status"
                                                       @if($category->status == 1) checked @endif>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status"
                                                       @if($category->status == 0) checked @endif>
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit"
                                                class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.categories.index')}}">{{ trans('main.back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
{{--                        <div class="tab-pane @if($tab == 'category_images') active @endif" id="tab_2">--}}
{{--                            <form class="form-group" method="post"--}}
{{--                                  action="{{ route('admin.category.upload_images',$category->id) }}"--}}
{{--                                  enctype="multipart/form-data">--}}
{{--                                @csrf--}}
{{--                                <input type="file" name="images[]" multiple>--}}
{{--                                <input type="submit" class="btn btn-danger">--}}
{{--                            </form>--}}
{{--                            @if($category->images && $category->images->count() > 0)--}}
{{--                                <h4 class="mb-2 mt-5">عکس ها</h4>--}}
{{--                                <div class="row">--}}
{{--                                    @if($image = $category->image)--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="card card-warning">--}}
{{--                                                <div class="card-header">--}}
{{--                                                    <h3 class="card-title">عکس</h3>--}}

{{--                                                    <div class="card-tools">--}}
{{--                                                        <button type="button" onclick="removeImage({{ $image->id }})"--}}
{{--                                                                class="btn btn-tool" data-widget="remove"><i--}}
{{--                                                                    class="fa fa-times"></i>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                    <!-- /.card-tools -->--}}
{{--                                                </div>--}}
{{--                                                <!-- /.card-header -->--}}
{{--                                                <div >--}}

{{--                                                    <img class="edit-category-image"--}}
{{--                                                         src="{{ $image }}" width="330" height="328">--}}
{{--                                                </div>--}}
{{--                                                <!-- /.card-body -->--}}
{{--                                            </div>--}}
{{--                                            <!-- /.card -->--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}

                        <div class="tab-pane @if($tab == 'category_images') active @endif" id="tab_2">
                            <form style="@if($category->image) display:none @endif" class="form-group image-uploader" method="post"
                                  action="{{ route('admin.category.upload_images',$category->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div dd class="card-footer">
                                    <div class="float-left">
                                        <button type="submit" class="btn btn-primary"> ارسال</button>
                                    </div>
                                    <div class="btn btn-default btn-file">
                                        <i class="fa fa-paperclip"></i> فایل ضمیمه
                                        <input type="file" name="image" multiple>
                                    </div>
                                </div>
                            </form>
                            @if($category->image)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">عکس</h3>
                                                <div class="card-tools">
                                                    <button type="button" onclick="removeImage({{ $category->image()->first()->id }})"
                                                            class="btn btn-tool" data-widget="remove"><i
                                                                class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <img class="edit-slider-image"
                                                 src="{{ $category->image }}" style="margin: auto">
                                        </div>
                                    </div>
                                </div>
                            @endif
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
    {{--                        Remove Category Image                                --}}
    <script>
        function removeImage(index) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: "/admin/categories/{{ $category->id }}/image/" + index + "/delete",
                data: {_token: CSRF_TOKEN, message: $(".getinfo").val()},
                success: function (data) {
                    // alert(data.success); no need to response
                }
            });
        }
    </script>



    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endpush


