@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


    <section class="content">
        <div class="card">
            <div class="card-body">
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" method="GET"  action="{{ route('admin.users.index') }}" class="form-control">
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
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>موبایل</th>
                        <th>لاگین</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key =>  $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td style="direction: ltr">{{ $user->email }}</td>
                            <td style="direction: ltr">{{ $user->mobile }}</td>
                            <td width="20">
                                <input type="hidden" name="_method" value="delete">
                                <a target="_blank" class="btn btn-md btn-primary"  href="{{ route('admin.admins.loginAs',$user->id) }}" > <i class="fa fa-sign-in"></i></a>
                            </td>
                            <td width="20">
                                @can('update', \App\Models\Site\User::class)
                                    <a class="btn btn-md btn-warning" href="{{ route('admin.users.edit',$user->id) }}"  >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @elsecan('view',\App\Models\Site\User::class)
                                    <a class="btn btn-md btn-warning" disabled title="شما دسترسی ندارید">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                            </td>
                            <td width="20">
                                @can(['delete'], \App\Models\Site\User::class)
                                    <form action="{{ route('admin.users.delete',$user->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <a  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit" > <i class="fa fa-trash"></i></a>
                                    </form>
                                @elsecan('view',\App\Models\Site\User::class)
                                    <form>
                                        <a  disabled title="شما دسترسی ندارید" class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></a>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        {{ $users->links() }}
        <!-- /.card-body -->
        </div>
    </section>

@endsection()
