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
</head>

<body>
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-md text-white bg-secondary text-left" style="background-image: linear-gradient(to bottom right, white, #17a2b8);">
                <div class="container-fluid">
                    <a class="navbar-brand text-white navbar-header" href="{{ route('home') }}">
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
                            <li class="nav-item dropdown" role="presentation">
                                <a class="nav-link" style="color:#006400"  href="{{ route('home') }}">Home</a>
                            </li>
                            @if(count(\App\Http\Controllers\MainController::aksesUser()) > 0)
                                @foreach (\App\Http\Controllers\MainController::aksesUser() as $groupmodule => $module)
                                <li class="nav-item dropdown" role="presentation">
                                    <a class="nav-link dropdown-toggle" style="color:#006400" data-toggle="dropdown" href="#">{{ $groupmodule }}</a>
                                    @if(is_array($module) && count($module) > 0)
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            @foreach($module as $modules)
                                                <a class="dropdown-item" href="{{ route($modules['route']) }}">{{ $modules['deskripsi'] }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                                @endforeach
                            @endif
                            <li class="nav-item dropdown" role="presentation">
                                <a href="#" class="nav-link dropdown-toggle" style="color:#006400" data-toggle="dropdown"><img class="rounded-circle" style="margin-top: -7px; max-height: 34px;" src="{{ url('/') }}/assets/images/user/{{ isset($loginuser['foto']) && $loginuser['foto'] != "" ? $loginuser['foto'] : "user.png" }}"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item input" title="Ubah Password" href="{{ route('ubahpassword') }}">Ubah Password</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        
        <div class="container">
            <h1 class="text-center">@yield('judul')</h1>
            <div role="tablist" id="accordion-1">
                <div class="card">
                    <div class="card-header text-white bg-info" role="tab">
                        <h5 class="text-center mb-0"><a class="text-white" data-toggle="collapse" aria-expanded="true" aria-controls="accordion-1 .item-1" href="#accordion-1 .item-1">Search</a></h5>
                    </div>
                    <div class="collapse item-1 {{ isset($_GET) && count($_GET) > 0 ? "show" : "" }}" role="tabpanel" data-parent="#accordion-1">
                        <div class="card-body">
                            @yield('filter')
                        </div>
                    </div>
                </div>
            </div>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            @yield('content')

            <div class="modal fade" id="modal-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                    <h5 class="modal-title text-white" id="modal-title">Title</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">     
                        <iframe id="modal-body" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <div class="container">
        <div class="footer-basic bg-secondary pt-4 pb-2 mt-5">
            <footer>
                <p class="copyright text-white text-center">Soleh © {{ date('Y')}}</p>
            </footer>
        </div>
    </div>
    <script src="{{ url('/')}}/assets/js/jquery.min.js"></script>
    <script src="{{ url('/')}}/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/')}}/assets/js/lib.js"></script>
    <script src="{{ url('/')}}/assets/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ url('/')}}/assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ url('/') }}/assets/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".input").on('click',function(){
                openModal(this.title,this.href);
                return false;
           });
        });
    </script>
    @yield('js')
</body>

</html>