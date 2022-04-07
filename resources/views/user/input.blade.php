@extends('layout.input')

@section('title')
    User
@endsection

@section('judul')
    User
@endsection

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="from-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control form-control-sm input-sm" value="{{ old('username',isset($data['username']) ? $data['username'] : '') }}">
                    <div class="text-danger">
                        @error('username')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm input-sm" value="{{ old('nama',isset($data['nama']) ? $data['nama'] : '') }}">
                    <div class="text-danger">
                        @error('username')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" class="form-control form-control-sm input-sm" value="{{ old('password') }}">
                    <div class="text-danger">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control form-control-sm input-sm" value="{{ old('email',isset($data['email']) ? $data['email'] : '') }}">
                    <div class="text-danger">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group_user_id">Group</label>
                    <select name="group_user_id" id="group_user_id" class="form-control form-control-sm input-sm my-select" data-live-search="true">
                        <option value="">--</option>
                        @foreach ($groupuser as $groupusers)
                            <option value="{{ $groupusers['id'] }}" {{ old('group_user_id',isset($data['group_user_id']) ? $data['group_user_id'] : '') == $groupusers['id'] ? 'selected' : '' }}>{{ $groupusers['deskripsi'] }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('group_user_id')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" class="form-control form-control-sm">
                    <div class="text-danger">
                        @error('foto')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-sm {{ isset($action) && $action == "Delete" ? "btn-danger" : "btn-primary" }}" type="submit">{{ isset($action) ? $action : "Submit" }}</button>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.my-select').selectpicker();
        });
    </script>
@endsection