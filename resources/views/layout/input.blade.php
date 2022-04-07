<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/datepicker/dist/css/bootstrap-datepicker.css">
    @yield('css')
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/styles.css">
    @yield('action')
    
</head>

<body>
    <div class="container-fluid text-center mx-auto">
        <nav class="navbar navbar-expand-lg navbar-light bg-info text-center mx-auto">
            <div class="container text-center mx-auto">
                <h2 class="text-white text-center mx-auto">@yield('judul')</h2>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @yield('content')
    </div>
    <script src="{{ url('/') }}/assets/js/jquery.min.js"></script>
    <script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/')}}/assets/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ url('/')}}/assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ url('/') }}/assets/sweetalert/sweetalert.min.js"></script>
    <script src="{{ url('/') }}/assets/js/lib.js"></script>
    @yield('js')
</body>

</html>