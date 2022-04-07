@extends('layout.index')

@section('title')
    Module
@endsection

@section('judul')
    Module
@endsection

@section('filter')
    <form action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control form-control-sm" value="{{ isset($_GET['deskripsi']) ? $_GET['deskripsi'] : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group_module_id">Group</label>
                    <select name="group_module_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($groupmodule as $groupmodules)
                            <option value="{{ $groupmodules['id'] }}" {{ isset($_GET['group_module_id']) && $_GET['group_module_id'] == $groupmodules['id'] ? "selected" : "" }}>{{ $groupmodules['deskripsi'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('content')
    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->buat == 'Y')
    <p>
        <a href="{{ route('module.create') }}" class="btn btn-sm btn-primary input" title="Create Module">Create</a>
    </p>
    @endif
    <div class="table-responsive">
        <table class="table table-hover table-stripped">
            <thead>
                <tr>
                    <th class="bg-info text-white text-center forn-weight-bold">Deskripsi</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Route</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Group</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Icon</th>
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                    <th class="bg-info text-white text-center forn-weight-bold">Ubah</th>
                    @endif
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                    <th class="bg-info text-white text-center forn-weight-bold">Hapus</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td>{{ $datas['deskripsi'] }}</td>
                        <td>{{ $datas['route'] }}</td>
                        <td class="text-center">{{ isset($datas->GroupModule->deskripsi) ? $datas->GroupModule->deskripsi : '' }}</td>
                        <td class="text-center">
                            @if($datas['icon'] != '')
                                <img class="img-thumbnail rounded mx-auto d-block" width="30" height="30" src="{{ url('/').'/assets/images/module/'.$datas['icon'] }}" alt="{{ $datas['deskripsi'] }}">
                            @endif
                        </td>
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                        <td class="text-center">
                            <a href="{{ route('module.edit',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Edit Module">Ubah</a>
                        </td>
                        @endif
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                        <td class="text-center">
                            <a href="{{ route('module.delete',['id' => $datas['id']]) }}" class="btn btn-sm btn-danger input" title="Delete Module">Hapus</a>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pull-left">
        {{ $data->links() }}
    </div>
    <div class="pull-right">
        Showing 
        {{ $data->firstItem() }}
        to 
        {{ $data->lastItem() }}
        of
        {{ $data->total() }}
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.my-select').selectpicker();
        });
    </script>
@endsection