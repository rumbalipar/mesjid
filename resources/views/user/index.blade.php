@extends('layout.index')

@section('title')
    User
@endsection

@section('judul')
    User
@endsection

@section('filter')
    <form action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="nama" class="form-control form-control-sm" value="{{ isset($_GET['nama']) ? $_GET['nama'] : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control form-control-sm" value="{{ isset($_GET['username']) ? $_GET['username'] : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control form-control-sm" value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group_user_id">Group</label>
                    <select name="group_user_id" id="" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($groupuser as $groupusers)
                            <option value="{{ $groupusers['id'] }}" {{ isset($_GET['group_user_id']) && $_GET['group_user_id'] == $groupusers['id'] ? "selected" : ""  }}>{{ $groupusers['deskripsi'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-info" type="submit">Search</button>
    </form>
@endsection

@section('content')
    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->buat == 'Y')
    <p>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary input" title="Create User">Create</a>
    </p>
    @endif
    <div class="table-responsive">
        <table class="table table-hover table-stripped">
            <thead>
                <tr>
                    <th class="bg-info text-white text-center forn-weight-bold">Nama</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Username</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Email</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Group</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Foto</th>
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
                        <td>{{ $datas['nama'] }}</td>
                        <td>{{ $datas['username'] }}</td>
                        <td class="text-center">{{ $datas['email'] }}</td>
                        <td>{{ isset($datas->GroupUser->deskripsi) ? $datas->GroupUser->deskripsi : '' }}</td>
                        <td class="text-center">
                            @if($datas['foto'] != '')
                                <img class="img-thumbnail rounded mx-auto d-block" width="30" height="30" src="{{ url('/').'/assets/images/user/'.$datas['foto'] }}" alt="{{ $datas['nama'] }}">
                            @endif
                        </td>
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                        <td class="text-center">
                            <a href="{{ route('user.edit',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Edit User">Ubah</a>
                        </td>
                        @endif
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                        <td class="text-center">
                            <a href="{{ route('user.delete',['id' => $datas['id']]) }}" class="btn btn-sm btn-danger input" title="Delete User">Hapus</a>
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