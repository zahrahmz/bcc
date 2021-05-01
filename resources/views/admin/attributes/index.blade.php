@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <section class="content">
        <div class="card">
            <div class="col-md-12">
                <a href="{{ route('admin.attributes.create') }}">
                    <button type="button"
                            class="btn float-left btn-primary btn-lg">{{ trans('attributes.add_attribute') }}</button>
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control">
                        <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat">{{ trans('main.search') }}</button>
                  </span>
                    </div>
                </form>
                <br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('main.row') }}</th>
                        <th>{{ trans('attributes.attribute_name') }}</th>
                        <th>{{ trans('attributes.created_at') }}</th>
                        <th>{{ trans('main.add_value') }}</th>
                        <th>{{ trans('main.edit') }}</th>
                        <th>{{ trans('main.delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attributes as $key => $attribute)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $attribute->attribute_name }}</td>
                            <td>{{ $attribute->converted_created_at }}</td>
                            <td width="20">
                                <a class="btn btn-md btn-info" href="{{ route('admin.attributevalues.create',['attribute' => $attribute->id]) }}">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </td>
                            <td width="20">
                                @can('update', \App\Models\Attribute::class)
                                    <a class="btn btn-md btn-warning" href="{{  route('admin.attributes.edit',$attribute->id)  }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @elsecan('view',\App\Models\Attribute::class)
                                    <button class="btn btn-md btn-warning" disabled title="شما دسترسی ندارید">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
                            </td>
                            <td width="20">
                                @can('delete', \App\Models\Attribute::class)
                                    <form action="{{ route('admin.attributes.delete',$attribute->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                    </form>
                                @elsecan('view',\App\Models\Attribute::class)
                                    <form>
                                        <button  disabled title="شما دسترسی ندارید" class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                    </form>
                                @endcan
                            </td>

{{--                            <td width="20">--}}
{{--                                <a class="btn btn-md btn-warning" href="{{ route('admin.attributes.edit',$attribute->id) }}">--}}
{{--                                    <i class="fa fa-edit"></i>--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td width="20">--}}
{{--                                <form action="{{ route('admin.attributes.delete',$attribute->id) }}" method="post">--}}
{{--                                    {{ csrf_field() }}--}}
{{--                                    <input type="hidden" name="_method" value="delete">--}}
{{--                                    <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>--}}
{{--                                </form>--}}

{{--                            </td>--}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
