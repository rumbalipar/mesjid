<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/datepicker/dist/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-md text-white bg-secondary text-left" style="background-image: linear-gradient(to bottom right, white, #17a2b8);">
            <div class="container-fluid">
                <a class="navbar-brand text-white navbar-header" href="{{ route('index') }}">
                    @if (isset($applicationcompany['logo']) && trim($applicationcompany['logo']) != '')
                        <img src="{{ url('/') }}/assets/images/{{ trim($applicationcompany['logo']) }}" style="max-height:40px;" alt="">
                        &nbsp; <span style="color:#006400">{{  trim($applicationcompany['nama']) }}</span>
                    @else
                        <img src="{{ url('/') }}/assets/images/logo.png" style="max-height:40px;" alt="">
                    @endif

                </a>
                <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Grafik
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('grafik.month') }}">Bulan</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('grafik.year') }}">Tahun</a>
                            </div>
                          </li>
                        <li class="nav-item dropdown" role="presentation">
                            <a class="nav-link" style="color:#006400" target="_blank"  href="{{ route('index.login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <div class="container">
        <div class="footer-basic bg-secondary pt-4 pb-2 mt-5">
            <footer>
                <p class="copyright text-white text-center">Wildan © {{ date('Y')}}</p>
            </footer>
        </div>
    </div>
    <script src="{{ url('/')}}/assets/js/jquery.min.js"></script>
    <script src="{{ url('/')}}/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/')}}/assets/js/lib.js"></script>
    <script src="{{ url('/')}}/assets/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ url('/')}}/assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ url('/') }}/assets/sweetalert/sweetalert.min.js"></script>
    <script src="{{ url('/') }}/assets/chartjs/chart.min.js"></script>
    @yield('js')
</body>
</html>