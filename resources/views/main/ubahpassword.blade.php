@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Ubah Password
@endsection

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="oldpassword">Current Password</label>
                <input type="password" name="oldpassword" class="form-control form-control-sm" value="{{ old('oldpassword') }}">
                <div class="text-danger">
                    @error('oldpassword')
                        <small>{{ $message }}}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="password">New Password</label>
                <input type="password" name="password" class="form-control form-control-sm" value="{{ old('password') }}">
                <div class="text-danger">
                    @error('password')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="repassword">Retype Password</label>
                <input type="password" name="repassword" class="form-control form-control-sm" value="{{ old('repassword') }}">
                <div class="text-danger">
                    @error('repassword')
                    <small>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
    </form>
@endsection