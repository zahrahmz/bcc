@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">
            @can('create', \App\Models\Product::class)
                    <div class="col-md-12">
                        <a href="{{ route('admin.products.create') }}">
                            <button type="button"
                                    class="btn float-left btn-primary btn-lg">{{ trans('products.add_product') }}</button>
                        </a>
                    </div>
            @endcan

            <!-- /.card-header -->
            <div class="card-body">
                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" method="GET"  action="{{ route('admin.products.index') }}" class="form-control">
                        <span class="input-group-append">
                    <button type="button" onclick="form.submit()" class="btn btn-info btn-flat">{{ trans('main.search') }}</button>
                  </span>
                    </div>
                </form>
                <br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('main.row') }}</th>
                        <th>{{ trans('products.product_name') }}</th>
                        <th>{{ trans('products.sku') }}</th>
                        <th>{{ trans('products.status') }}</th>
                        <th>{{ trans('products.created_at') }}</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key =>  $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->converted_created_at }}</td>
                            <td width="20">
                                @can('update', \App\Models\Product::class)
                                    <a class="btn btn-md btn-warning" href="{{ route('admin.products.edit',$product->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @elsecan('view',\App\Models\Product::class)
                                    <button class="btn btn-md btn-warning" disabled title="شما دسترسی ندارید">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
                            </td>
                            <td width="20">
                                @can('delete', \App\Models\Product::class)
                                    <form action="{{ route('admin.products.delete',$product->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                    </form>
                                @elsecan('view',\App\Models\Product::class)
                                    <form>
                                        <button  disabled title="شما دسترسی ندارید" class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $products->appends(['search' => $searchPhrase])->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
