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

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active "
                             id="tab_1">
                            <form action="{{ route('admin.settings.update',$setting->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('settings.setting_name') }}</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name" value="{{ $setting->name }}"
                                                   placeholder="{{ trans('settings.setting_name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('settings.value') }}</label>
                                            <input type="number" class="form-control @error('value') is-invalid @enderror"
                                                   name="value" value="{{ $setting->value }}"
                                                   placeholder="{{ trans('settings.value') }}">
                                            @error('value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status"
                                                       @if($setting->status == 1) checked @endif>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status"
                                                       @if($setting->status == 0) checked @endif>
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>{{ trans('settings.name') }}</label>
                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit"
                                                class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.settings.index')}}">{{ trans('main.back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col -->
    </div>
@endsection()



