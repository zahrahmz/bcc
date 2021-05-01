@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a
                                class="nav-link @if(empty($tab)) active @elseif($tab == 'product_attribute') active @endif"
                                href="#tab_1" data-toggle="tab">اطلاعات
                                محصول</a></li>
                        <li class="nav-item"><a class="nav-link @if($tab == 'product_images') active @endif"
                                                href="#tab_2" data-toggle="tab">عکس محصول</a></li>
                        <li class="nav-item"><a class="nav-link @if($tab == 'product_attribute_value') active @endif"
                                                href="#tab_3" data-toggle="tab">ویژگی های محصول</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane @if(empty($tab)) active @elseif($tab == 'product_attribute') active @endif"
                             id="tab_1">
                            <form action="{{ route('admin.products.update',$product->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('products.product_name') }}</label>
                                            <input type="text"
                                                   class="form-control @error('product_name') is-invalid @enderror"
                                                   name="product_name" value="{{ $product->product_name }}"
                                                   placeholder="{{ trans('products.product_name') }}">
                                            @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.sku') }}</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                   name="sku" value="{{ $product->sku }}"
                                                   placeholder="{{ trans('products.sku') }}">
                                            @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.slug') }}</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   name="slug" value="{{ $product->slug }}"
                                                   placeholder="{{ trans('products.slug') }}">
                                            @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.description') }}</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      name="description"
                                                      placeholder="{{ trans('products.description') }}">{{ $product->description }}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('products.price') }}</label>
                                            <input type="text" class="form-control @error('price') is-invalid @enderror"
                                                   name="price" value="{{ $product->price }}"
                                                   placeholder="{{ trans('products.price') }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="status"
                                                       @if($product->status == 1) checked @endif>
                                                <label class="form-check-label">{{ trans('main.active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="0" name="status"
                                                       @if($product->status == 0) checked @endif>
                                                <label class="form-check-label">{{ trans('main.inactive') }}</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>جنسیت</label>
                                            <select class="form-control select2 select2-hidden-accessible  @error('gender') is-invalid @enderror" name="gender"  data-placeholder="نوع جنسیت را مشخص کنید" style="width: 100%;text-align: right" tabindex="-1" aria-hidden="true">
                                                @foreach(\App\Models\Product::GENDER as $key => $value)
                                                    <option @if(old('gender',$product->gender)  == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <div class="form-check">
                                            <div class="form-group">
                                                <label>{{ trans('categories.name') }}</label>
                                                <select
                                                    class="form-control select2 select2-hidden-accessible @error('categories') is-invalid @enderror"
                                                    name="categories[]" multiple=""
                                                    data-placeholder="یک دسته بندی انتخاب کنید"
                                                    style="width: 100%;text-align: right" tabindex="-1"
                                                    aria-hidden="true">
                                                    @foreach($categories as $category)
                                                        <option
                                                            @if(in_array($category->id,old('categories',$product->categories->pluck('id')->toArray()))) selected
                                                            @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('categories')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <input @if(old('featured',$product->featured)) checked @endif name="featured"
                                                           type="checkbox" class="flat-red">
                                                    محصول ویژه
                                                </label>
                                            </div>
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

                        <div class="tab-pane @if($tab == 'product_images') active @endif" id="tab_2">

                            <div class="form-group">
                                <form class="form-group" method="post"
                                      action="{{ route('admin.product.upload_images',$product->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-footer">
                                        <div class="float-left">
                                            <button type="submit" class="btn btn-primary"> ارسال</button>
                                        </div>
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> فایل ضمیمه
                                            <input type="file" name="images[]" multiple>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if($product->images->count() > 0)
                                <h4 class="mb-2 mt-5">عکس ها</h4>
                                <div class="row">
                                    @foreach($product->images as $imageId => $image)
                                        <div class="col-md-3">
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">عکس</h3>

                                                    <div class="card-tools">
                                                        <button type="button" onclick="removeImage({{ $imageId }})"
                                                                class="btn btn-tool" data-widget="remove"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <img class="edit-product-image"
                                                         src="{{$image}}">
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane @if($tab == 'product_attribute_value') active @endif" id="tab_3">
                            <div class="card">
                                <div class="col-md-12">
                                    <a href="{{ route('admin.products.assignAttributes',$product->id) }}">
                                        <button type="button"
                                                class="btn float-left btn-primary btn-lg">{{ trans('attributes.add_attribute') }}</button>
                                    </a>
                                </div>
                                <div class="card-body">


                                    <table class="table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Attributes</th>
                                            <th >Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($productAttributes as $pa)
                                            @if(!$pa->attributesValues->isEmpty())
                                                <tr>
                                                <td width="50">{{ $pa->id }}</td>
                                                <td width="300">
                                                    <a href="#" class="editable" name="pirce" data-pk=pk{{ $pa->id }}" data-url="{{ route('admin.products.updateProductQuantityAttribute',['product' =>$product->id,'attribute' => $pa->id]) }}">
                                                        {{ $pa->quantity }}
                                                    </a>
                                                </td>
                                                <td width="300">
                                                    <a href="#" class="editable" name="pirce" data-pk=pk{{ $pa->id }}" data-url="{{ route('admin.products.updateProductPriceAttribute',['product' =>$product->id,'attribute' => $pa->id]) }}">
                                                        {{ $pa->formatted_price }}
                                                    </a>
                                                </td>
                                                <td  width="50">
                                                    <ul class="list-unstyled">
                                                        @foreach($pa->attributesValues as $item)
                                                                <li>
                                                                    <span class="right badge badge-warning">{{ $item->attribute->attribute_name }} : {{ $item->value }}</span>
                                                                </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td width="20">
                                                    <form action="" >
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete">
                                                        <button  onclick="return confirm('آیا اطمینان دارید؟')"  class="btn btn-md btn-danger" type="submit"> <i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endif
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

@push('scripts')

    {{--                        Remove Product Image                                --}}
    <script>
        function removeImage(index) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: "/admin/products/{{ $product->id }}/image/" + index + "/delete",
                data: {_token: CSRF_TOKEN, message: $(".getinfo").val()},
                success: function (data) {
                    // alert(data.success); no need to response
                }
            });
        }
    </script>




    {{--                        For Editable table(x-editable)                        --}}
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {type: "PATCH"};

        $('.editable').editable({
            type: 'text',
            title: 'Enter value',
            value: '',
            error: function (errors) {
                alert(1)
            },
            success: function(response, newValue) {
                return {newValue: response['data']['price']};
            }
        });
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
    </script>

@endpush


