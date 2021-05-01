@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <section class="content">
        <div class="card">
            @can('create', \App\Models\Discount::class)
                <div class="col-md-12">
                    <a href="{{ route('admin.discount.create') }}">
                        <button type="button"
                                class="btn float-left btn-primary btn-lg">{{ trans('discount.create_discount') }}</button>
                    </a>
                </div>
        @endcan
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
                        <th>{{ trans('discount.title') }}</th>
                        <th>{{ trans('discount.percent') }}</th>
                        <th>{{ trans('discount.type') }}</th>
                        <th>{{ trans('discount.start_date') }}</th>
                        <th>{{ trans('discount.end_date') }}</th>
                        <th>{{ trans('discount.status') }}</th>
                        <th>{{ trans('main.delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $key =>  $discount)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $discount->title }}</td>
                            <td>{{ $discount->percent }}</td>
                            <td>{{ $discount->type}}</td>
                            <td>{{ $discount->start_date }}</td>
                            <td>{{ $discount->end_date }}</td>
                            <td>{{ $discount->status == 1 ? "فعال" : "غیرفعال" }}</td>
                            <td width="20">
                                @can('delete', \App\Models\Discount::class)
                                    <form action="{{ route('admin.discount.delete',$discount->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <button onclick="return confirm('آیا اطمینان دارید؟')"
                                                class="btn btn-lg btn-danger" type="submit"><i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-lg"
                                           href="{{ route('admin.discount.delete',$discount->id) }}"> </a>
                                    </form>
                                @elsecan('view',\App\Models\Discount::class)
                                    <form>
                                        <button disabled title="شما دسترسی ندارید" class="btn btn-md btn-danger"
                                                type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $discounts->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
