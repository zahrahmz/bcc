@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
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
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                            <form action="{{ route('admin.products.storeAssignAttributes',$product->id) }}" name="assign_attribute" method="post">
                                {{ @csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <div class="callout callout-info">
                                                <h5>ویژگی ها</h5>
                                        @foreach($attributes as $attribute)
                                            <div class="form-group " style="padding: 8px;">
                                                <label>{{ $attribute->attribute_name }}</label>
                                                <input type="checkbox"  onmousedown="this.form.select_{{ $attribute->id }}.disabled=this.checked"/>
                                                <select class="form-control @error('attribute_value_id') is-invalid @enderror" name="attribute_value_id[]" id="select_{{ $attribute->id }}"  disabled>
                                                    <option value="-1">----</option>
                                                    @foreach($attribute->values as $value)
                                                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('attribute_value_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endforeach
                                            </div>
                                        </div>
                                            <div class="form-group">
                                                <label>تعداد</label>
                                                <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="وارد کردن اطلاعات ...">
                                                @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>قیمت</label>
                                                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="وارد کردن اطلاعات ...">
                                                @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="text"  name="product_id" value="{{ $product->id }}" class="form-control" hidden>
                                            </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class=" float-left btn  btn-danger">{{ trans('main.save') }}</button>
                                        <a class="float-left btn  btn-info" href="{{route('admin.products.edit',['product'=> $product->id,'tab' => 'product_attribute_value'])}}">{{ trans('main.back') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col -->
    </div>
@endsection()
