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

            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a
                                class="nav-link @if(empty($tab)) active @elseif($tab == 'slider_attribute') active @endif"
                                href="#tab_1" data-toggle="tab">اطلاعات
                                اسلایدر</a></li>
                        <li class="nav-item"><a class="nav-link @if($tab == 'slider_images') active @endif"
                                                href="#tab_2" data-toggle="tab">عکس اسلایدر</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane @if(empty($tab)) active @elseif($tab == 'slider_attribute') active @endif"
                             id="tab_1">
                            <form action="{{ route('admin.sliders.update',$slider->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('sliders.section') }}</label>
                                            <select name="section" id="">
                                                <option value="{{ \App\Models\Slider::HOME_MIDDLE }}">عکس دختر و پسر</option>
                                                <option value="{{ \App\Models\Slider::HOME_TOP }}">اسلایدر</option>
                                            </select>
                                            @error('section')
                                            <span class="invalid-feedback validation-error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('sliders.link') }}</label>
                                            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $slider->link }}"
                                                   placeholder="{{ trans('sliders.link') }}">
                                            @error('link')
                                            <span class="invalid-feedback validation-error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status"
                                                       @if($slider->status == 1) checked @endif>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status"
                                                       @if($slider->status == 0) checked @endif>
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-12">
                                        <button type="submit"
                                                class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.sliders.index')}}">{{ trans('main.back') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane @if($tab == 'slider_images') active @endif" id="tab_2">
                            <form style="@if($slider->image) display:none @endif" class="form-group image-uploader" method="post"
                                  action="{{ route('admin.sliders.upload_image',$slider->id) }}"
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
                            @if($slider->image)
                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">عکس</h3>
                                                    <div class="card-tools">
                                                        <button type="button" onclick="removeImage({{ $slider->image()->first()->id }})"
                                                                class="btn btn-tool" data-widget="remove"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                    <img class="edit-slider-image"
                                                         src="{{ $slider->image }}" style="margin: auto">
                                            </div>
                                        </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

@push('scripts')

    {{--                        Remove Slider Image                                --}}
    <script>
        function removeImage(index) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: "/admin/sliders/{{ $slider->id }}/image/" + index + "/delete",
                data: {_token: CSRF_TOKEN},
                success: function (data) {
                    $('.image-uploader').css('display','block')
                }
            });
        }
    </script>

@endpush


