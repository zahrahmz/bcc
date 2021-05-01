<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @include('admin.layouts.style')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" >
    @if(!empty($sidebarName))
        @include('admin.layouts.sidebar')
    @endif
    <div class="@if(!empty($sidebarName)) content-wrapper @endif">
        @if(!empty($sidebarName))
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">{{ $pageTitle }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('admin.layouts.error-and-messages')
        <section class="content" id="app">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    @include('admin.layouts.footer')
</div>
@include('admin.layouts.scripts')
@stack('scripts')
</body>
</html>

