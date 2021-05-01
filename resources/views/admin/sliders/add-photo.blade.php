@extends('admin.app')
@section('title')  افزودن عکس @endsection
@section('content')

    <section class="content">

                <div class="card-body">
                    <div class="tab-content">
                        <form class="form-group" method="post"
                              action="{{ route('admin.slider.upload_image',$slider->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="images[]" multiple>
                            <input type="submit" class="btn btn-danger">
                        </form>
                        @if($slider->images->count() > 0)
                            <h4 class="mb-2 mt-5">عکس ها</h4>
                            <div class="row">
                                @foreach($slider->images as $image)
                                    <div class="col-md-3">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">عکس</h3>

                                                <div class="card-tools">
                                                    <button type="button" onclick="removeImage({{ $image->id }})"
                                                            class="btn btn-tool" data-widget="remove"><i
                                                                class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div >

                                                <img class="edit-slider-image"
                                                     src="{{ $image }}" width="330" height="328">
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

            </div>


    <a class="float-left btn  btn-info" href="{{route('admin.sliders.index')}}">{{ trans('main.back') }}
    </a>
    </section>

@endsection()

@push('scripts')

    {{--                        Remove Slider Image                                --}}
    <script>
        function removeImage(index) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: "/admin/sliders/{{ $slider->id }}/image/" + index + "/delete",
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
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
            success: function (response, newValue) {
                return {newValue: response['data']['name']};
            }
        });
    </script>

@endpush
