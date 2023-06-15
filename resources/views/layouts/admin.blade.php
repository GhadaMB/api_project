<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

<!-- Styles -->

<!-- Favicons -->
<link href="{{ asset('admin/img/favicon.pngcss') }}" rel="icon">
<link href="{{ asset('admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/style2.css') }}" rel="stylesheet">

<!-- Fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Bootstrap Icons Starts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<!-- Template Main CSS File -->
<link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">

</head>
<body>
@include('layouts.inc.adminHeader')
@include('layouts.inc.sidebar')

<main id="main" class="main">
    @include('layouts.inc.adminPageTitle')


    <section class="section dashboard">
        <div class="row">
            @yield('content')
        </div>
    </section>
</main><!-- End #main -->

@include('layouts.inc.adminFooter')


<!-- Template Main JS File -->
<script src="{{ asset('admin/js/main.js') }}"></script>
<!-- Scripts -->
<script src="{{ asset('admin/js/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('admin/js/chart.umd.js') }}" defer></script>
<script src="{{ asset('admin/js/echarts.min.js') }}" defer></script>
<script src="{{ asset('admin/js/quill.min.js') }}" defer></script>
<script src="{{ asset('admin/js/simple-datatables.js') }}" defer></script>
<script src="{{ asset('admin/js/tinymce.min.js') }}" defer></script>
<script src="{{ asset('admin/js/validate.js') }}" defer></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if(session('status'))
    <script>
        swal({
            text: "{{ session('status') }}",
        });
    </script>
@endif
@yield('scripts')
</body>
</html>
