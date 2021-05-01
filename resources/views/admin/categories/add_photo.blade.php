@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-md-6">
                        <form class="form-group" method="post"
                              action="{{ route('admin.category.upload_images',$category->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="images[]" multiple>
                            <input type="submit" class="btn btn-danger float-left">
                        </form>
                    </div>
                    @if( null !== $category->image && $category->image->count() > 0)
                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">عکس</h3>

                                        <div class="card-tools">
                                            <button type="button" onclick="removeImage({{ $category->image->id }})"
                                                    class="btn btn-tool" data-widget="remove"><i
                                                    class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div>

                                        <img class="edit-category-image"
                                             src="{{ $category->image }}" width="100%">
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                    @endif
                </div>
            </div>
        </div>

        <a class="float-left btn  btn-info" href="{{route('admin.categories.index')}}">{{ trans('main.back') }}
            </a>
    </section>

@endsection()

@push('scripts')

    {{--                        Remove Category Image                                --}}
    <script>
        function removeImage(index) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: "/admin/categories/{{ $category->id }}/image/" + index + "/delete",
                data: {_token: CSRF_TOKEN, message: $(".getinfo").val()},
                success: function (data) {
                    // alert(data.success); no need to response
                }
            });
        }
    </script>

@endpush
