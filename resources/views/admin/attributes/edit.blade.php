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
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ trans('main.feature') }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attributes.update',$attribute->id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('attributes.attribute_name') }}</label>
                                    <input type="text"
                                           class="form-control @error('attribute_name') is-invalid @enderror"
                                           name="attribute_name" value="{{ $attribute->attribute_name }}"
                                           placeholder="{{ trans('attributes.attribute_name') }}">
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
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ trans('main.values') }}
                    </h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if($attribute->values->count() > 0)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>{{ trans('main.row') }}</th>
                                    <th>{{ trans('product_attribute.value') }}</th>
                                    <th>{{ trans('product_attribute.created_at') }}</th>
                                    <th>{{ trans('main.delete') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attribute->values as $key =>  $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->value }}</td>
                                        <td>{{ $value->converted_created_at }}</td>
                                        <td width="20">
                                            <form
                                                action="{{ route('admin.attributevalues.delete',['attribute' => $attribute->id,'value' =>$value->id]) }}"
                                                method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <button onclick="return confirm('آیا اطمینان دارید؟')"
                                                        class="btn btn-md btn-danger" type="submit"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <a class="btn btn-md btn-info float-left ml-1 mb-2"
                           href="{{ route('admin.attributevalues.create',['attribute' => $attribute->id]) }}">
                           {{ trans('attributevalues.add_attribute_value') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()



