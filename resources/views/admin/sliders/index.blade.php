@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">
            @can('create', \App\Models\Slider::class)
                    <div class="col-md-12">
                        <a href="{{ route('admin.sliders.create') }}">
                            <button type="button"
                                    class="btn float-left btn-primary btn-lg">{{ trans('sliders.create_slider') }}</button>
                        </a>
                    </div>
            @endcan

            <!-- /.card-header -->
            <div class="card-body">
                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" method="GET"  action="{{ route('admin.sliders.index') }}" class="form-control">
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
                        <th>{{ trans('sliders.section') }}</th>
                        <th>{{ trans('sliders.status') }}</th>
                        <th>{{ trans('sliders.created_at') }}</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $key =>  $slider)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $slider->section }}</td>
                            <td>{{ $slider->status == 1 ? "فعال" : "غیرفعال" }}</td>
                            <td>{{ verta($slider->created_at)->format('Y-n-j') }}</td>

                            <td width="20">

                                @can('update', \App\Models\Slider::class)
                                    <a class="btn btn-md btn-warning" href="{{ route('admin.sliders.edit',$slider->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @elsecan('view',\App\Models\Slider::class)
                                    <button class="btn btn-md btn-warning" disabled title="شما دسترسی ندارید">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
                            </td>
                            <td width="20">
                                @can('delete', \App\Models\Slider::class)
                                    <form action="{{ route('admin.sliders.delete',$slider->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                    </form>
                                @elsecan('view',\App\Models\Slider::class)
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
        {{ $sliders->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
