@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @php($tab = session()->get('tab'))
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
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a
                                class="nav-link @if(empty($tab)) active @elseif($tab == 'product_attribute') active @endif"
                                href="#tab_1" data-toggle="tab">اطلاعات کاربر</a></li>
                        <li class="nav-item"><a class="nav-link @if($tab == 'product_images') active @endif"
                                                href="#tab_2" data-toggle="tab">آدرس ها</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane @if(empty($tab)) active @elseif($tab == 'product_attribute') active @endif"
                             id="tab_1">
                            <form action="{{ route('admin.users.update',$user->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>نام مشتری</label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="product_name" value="{{ $user->name }}"
                                                   placeholder="نام مشتری">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>موبایل</label>
                                            <input type="text"
                                                   class="form-control @error('mobile') is-invalid @enderror"
                                                   name="sku" value="{{ $user->mobile }}"
                                                   placeholder="موبایل">
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>ایمیل</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                   name="slug" value="{{ $user->email }}"
                                                   placeholder="ایمیل">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>تاریخ تایید</label>
                                            <p>@if($user->mobile_verified_at) {{ verta($user->mobile_verified_at)->format('Y-m-d') }} @else <span
                                                    style="color: red">تایید نشده</span> @endif</p>
                                        </div>
                                        <div class="form-group">
                                            <label>پسورد</label>
                                            <input type="text"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="quantity" value=""
                                                   placeholder="پسورد">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit"
                                                class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info"
                                           href="{{route('admin.products.index')}}">{{ trans('main.back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane @if($tab == 'product_attribute_value') active @endif" id="tab_2">
                            <div class="card">
                                <div class="col-md-12">
                                    <a href="{{ route('admin.addresses.create',$user->id) }}">
                                        <button type="button"
                                                class="btn float-left btn-primary btn-lg">اضافه کردن آدرس
                                        </button>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>نام استان</th>
                                            <th>نام شهر</th>
                                            <th>آدرس</th>
                                            <th>کدپستی</th>
                                            <th>شماره تلفن گیرنده</th>
                                            <th>نام گیرنده</th>
                                            <th>اصلاح</th>
                                            <th>ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user->addresses as $row => $address)

                                            <tr>
                                                <td width="50">{{ $row +1 }}</td>
                                                <td width="70">
                                                    {{ $address->province }}
                                                </td>
                                                <td width="70">
                                                    {{ $address->city }}
                                                </td>
                                                <td width="500">
                                                    {{ $address->address }}
                                                </td>
                                                <td width="80">
                                                    {{ $address->postal_code }}
                                                </td>
                                                <td width="70">
                                                    {{ $address->phone }}
                                                </td>
                                                <td width="100">
                                                    {{ $address->name_of_receiver }}
                                                </td>
                                                <td width="30">
                                                    <a class="btn btn-md btn-warning" href="{{ route('admin.users.edit',$user->id) }}"  >
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td width="30">
                                                    <form action="{{ route('admin.users.delete',$user->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete">
                                                        <a  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit" > <i class="fa fa-trash"></i></a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()


