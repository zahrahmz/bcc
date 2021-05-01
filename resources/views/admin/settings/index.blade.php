@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">

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
                        <th>{{ trans('settings.setting_name') }}</th>
                        <th>{{ trans('settings.value') }}</th>
                        <th>{{ trans('settings.status') }}</th>
                        <th>{{ trans('settings.created_at') }}</th>
                        <th>{{ trans('main.edit') }}</th>
{{--                        <th>{{ trans('main.delete') }}</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($settings as $key =>  $setting)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>{{ $setting->status == 1 ? "فعال" : "غیرفعال" }}</td>
                            <td>{{ verta($setting->created_at)->format('Y-n-j') }}</td>
                            <td width="20">
                                <a class="btn btn-lg btn-warning" href="{{ route('admin.settings.edit',$setting->id) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            {{--<td width="20">--}}
                                {{--<form action="{{ route('admin.settings.destroy',$setting->id) }}" method="post">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<input type="hidden" name="_method" value="delete">--}}
                                    {{--<button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-lg btn-danger" type="submit"> <i class="fa fa-trash"></i></button>--}}
                                {{--</form>--}}
{{--                                <a class="btn btn-lg" href="{{ route('admin.settings.delete',$setting->id) }}">--}}
{{--                                   --}}
{{--                                </a>--}}
                            {{--</td>--}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $settings->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
