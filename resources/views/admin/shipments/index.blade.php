@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">
            <div class="col-md-12">
                <a href="{{ route('admin.shipments.create') }}">
                    <button type="button"
                            class="btn float-left btn-primary btn-lg">{{ trans('shipments.add_shipment') }}</button>
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
                        <th>{{ trans('shipments.shipment_name') }}</th>
                        <th>{{ trans('shipments.price') }}</th>
                        <th>{{ trans('shipments.status') }}</th>
                        <th>{{ trans('shipments.created_at') }}</th>
                        <th>{{ trans('main.edit') }}</th>
                        <th>{{ trans('main.delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shipments as $key =>  $shipment)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $shipment->name }}</td>
                            <td>{{ $shipment->price }}</td>
                            <td>{{ $shipment->status == 1 ? "فعال" : "غیرفعال" }}</td>
                            <td>{{ verta($shipment->created_at)->format('Y-n-j') }}</td>
                            <td width="20">
                                <a class="btn btn-lg btn-warning" href="{{ route('admin.shipments.edit',$shipment->id) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td width="20">
                                <form action="{{ route('admin.shipments.destroy',$shipment->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-lg btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                </form>
{{--                                <a class="btn btn-lg" href="{{ route('admin.shipments.delete',$shipment->id) }}">--}}
{{--                                   --}}
{{--                                </a>--}}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $shipments->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
