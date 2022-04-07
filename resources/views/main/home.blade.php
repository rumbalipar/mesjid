@extends('layout.index')

@section('title')
    Home
@endsection



@section('content')
<div class="card">
    
    <div class="card-body">
        <form action="">
            <div class="input-group" style="margin-top: 20px;margin-bottom: 20px;">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
                <input class="form-control border-info" placeholder="Ketik di sini untuk mencari" id="myInput" type="text" name="deskripsi" value="{{ old('deskripsi',isset($_GET['deskripsi']) ? $_GET['deskripsi'] : '') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        
        <div class="row">
            <div class="accordion" id="accordion" style="width: 100%">
                @foreach ($data as $groupmodule => $module)
                    <div class="card">
                        <div class="card-header" id="{{ str_replace(' ','',$groupmodule) }}" style="padding:0;">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-center btn-sm btn-info text-white" type="button" data-toggle="collapse" data-target="#collapse{{ str_replace(' ','',$groupmodule) }}" aria-expanded="true" aria-controls="collapse{{ str_replace(' ','',$groupmodule) }}">
                                {{ $groupmodule }}
                                </button>
                            </h2>
                        </div>
                        <div id="collapse{{ str_replace(' ','',$groupmodule) }}" class="collapse show" aria-labelledby="{{ str_replace(' ','',$groupmodule) }}" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    @if(is_array($module) && count($module) > 0)
                                    <div class="col-md-6">
                                        <div class="row">
                                            @foreach ($module as $key => $modules)
                                                <div class="col col-3 col-md-3 item" style="padding: 0px 5px;margin-bottom:10px;">
                                                    <div class="card border-info">
                                                        <div class="card-header bg-info" style="padding: 12px 12px;">
                                                            <h6 class="text-nowrap text-center text-white mb-0">
                                                                <a class="text-white item-desc font-weight-bold" href="{{ route($modules['route']) }}">
                                                                    {{ $modules['deskripsi'] }}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                        <div class="card-body" style="padding: 0px;">
                                                            <a href="{{ route($modules['route']) }}">
                                                                <img class="img-fluid" src="{{ url('/')}}/assets/images/module/{{ $modules['icon'] }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (($key+1) % 4 == 0)
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                                        @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $("#accordion-1").hide();
        });
    </script>
@endsection