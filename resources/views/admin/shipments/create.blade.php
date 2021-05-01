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
                            <form action="{{ route('admin.shipments.store') }}" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('shipments.shipment_name') }}</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                                                   placeholder="{{ trans('shipments.shipment_name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label>{{ trans('shipments.price') }}</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"  value="{{ old('price') }}" placeholder="{{ trans('shipments.price') }}">
                                            @error('price')
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
                                        <a class="float-left btn  btn-info" href="{{route('admin.shipments.index')}}">{{ trans('main.back') }}
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
