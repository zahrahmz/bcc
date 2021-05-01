@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('admin.sliders.store') }}" method="post">
                                {{ @csrf_field() }}
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
                                            <input style="direction: ltr;" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}"
                                                   placeholder="{{ trans('sliders.link') }}">
                                            @error('link')
                                            <span class="invalid-feedback validation-error" role="alert">
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
                                        <a class="float-left btn  btn-info" href="{{route('admin.sliders.index')}}">{{ trans('main.back') }}</a>

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
