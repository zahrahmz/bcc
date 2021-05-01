@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">
            <div class="col-md-12">
                <a href="{{ route('admin.categories.create') }}">
                    <button type="button"
                            class="btn float-left btn-primary btn-lg">{{ trans('categories.add_category') }}</button>
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
                        <th>{{ trans('categories.category_name') }}</th>
                        <th>{{ trans('categories.order') }}</th>
                        <th>{{ trans('categories.type') }}</th>
                        <th>{{ trans('categories.link') }}</th>
                        <th>{{ trans('categories.parent_id') }}</th>
                        <th>{{ trans('categories.description') }}</th>
                        <th>{{ trans('categories.status') }}</th>
                        <th>{{ trans('categories.created_at') }}</th>
                        <th>{{ trans('main.edit') }}</th>
                        <th>{{ trans('main.delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key =>  $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->type }}</td>
                            <td>{{ $category->link }}</td>
                            <td>{{ isset($category->parent_id)? $category->parent()->first()->name : "ندارد" }}</td>
                            <td>{{ substr($category->description,0,20) }}</td>
                            <td>{{ $category->status == 1 ? "فعال" : "غیرفعال" }}</td>
                            <td>{{ verta($category->created_at)->format('Y-n-j') }}</td>
                            <td width="20">
                                <a class="btn btn-lg btn-warning" href="{{ route('admin.categories.edit',$category->id) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td width="20">
                                <form action="{{ route('admin.categories.delete',$category->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-lg btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                </form>
{{--                                <a class="btn btn-lg" href="{{ route('admin.categories.delete',$category->id) }}">--}}
{{--                                   --}}
{{--                                </a>--}}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $categories->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
