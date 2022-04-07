@extends('layout.input')

@section('title')
    Module
@endsection

@section('judul')
    Module
@endsection

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control form-control-sm" value="{{ old('deskripsi',isset($data['deskripsi']) ? $data['deskripsi'] : '') }}">
                    <div class="text-danger">
                        @error('deskripsi')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Route</label>
                    <input type="text" name="route" class="form-control form-control-sm" value="{{ old('route',isset($data['route']) ? $data['route'] : '') }}">
                    <div class="text-danger">
                        @error('route')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group_module_id">Group</label>
                    <select name="group_module_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">--</option>
                        @foreach ($groupmodule as $groupmodules)
                            <option value="{{ $groupmodules['id'] }}" {{ old('group_module_id',isset($data['group_module_id']) ? $data['group_module_id'] : '') == $groupmodules['id'] ? "selected" : "" }}>{{ $groupmodules['deskripsi'] }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('group_module_id')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="icon">Icon</label>
                    <input type="file" name="icon" class="form-control form-control-sm">
                    <div class="text-danger">
                        @error('icon')
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