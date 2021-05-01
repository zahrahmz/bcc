@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">

                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attributes.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('main.value') }}</label>
                                    <input type="text"
                                           class="form-control @error('attribute_name') is-invalid @enderror"
                                           name="attribute_name" value="{{ old('attribute_name') }}"
                                           placeholder="{{ trans('main.value') }}">
                                    @error('attribute_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit"
                                        class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection()
@push('scripts')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endpush


