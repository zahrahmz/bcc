@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


<section class="content">
    <div class="card">
        @can('create', \App\Models\Admin::class)
        <div class="col-md-12">
            <a href="{{ route('admin.admins.create') }}">
                <button type="button" class="btn float-left btn-primary btn-lg">ایجاد کاربر مدیر</button>
            </a>
        </div>
        @endcan

        <!-- /.card-header -->
        <div class="card-body">
            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" method="GET"  action="{{ route('admin.admins.index') }}" class="form-control">
                    <span class="input-group-append">
                    <button type="button" onclick="form.submit()" class="btn btn-info btn-flat">جست‌وجو</button>
                  </span>
                </div>
            </form>
            <br>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربری</th>
                    <th>موبایل</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach($adminUsers as $key =>  $adminUser)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $adminUser->name }}</td>
                    <td style="direction: ltr">{{ $adminUser->mobile }}</td>
                    <td width="20">
                        @can('update', \App\Models\Admin::class)
                        <button class="btn btn-md btn-warning" href="{{ route('admin.admins.edit',$adminUser->id) }}" @if($adminUser->id == 1)  disabled title="کاربر ادمین غیر قابل وبرایش است" @endif >
                            <i class="fa fa-edit"></i>
                        </button>
                        @elsecan('view',\App\Models\Admin::class)
                        <button class="btn btn-md btn-warning" disabled title="شما دسترسی ندارید">
                            <i class="fa fa-edit"></i>
                        </button>
                        @endcan
                    </td>
                    <td width="20">
                        @can(['delete'], \App\Models\Admin::class)
                        <form action="{{ route('admin.admins.delete',$adminUser->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit" @if($adminUser->id == 1) disabled title="کاربر ادمین غیر قابل وبرایش است" @endif> <i class="fa fa-trash"></i></button>
                        </form>
                        @elsecan('view',\App\Models\Admin::class)
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
        {{ $adminUsers->links() }}
        <!-- /.card-body -->
    </div>
</section>

@endsection()
