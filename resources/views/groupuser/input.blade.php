@extends('layout.input')

@section('title')
    Group User
@endsection

@section('judul')
    Group User
@endsection

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" class="form-control form-control-sm input-sm" value="{{ old('kode',isset($data['kode']) ? $data['kode'] : '') }}">
                    <div class="text-danger">
                        @error('kode')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control form-control-sm input-sm" value="{{ old('deskripsi',isset($data['deskripsi']) ? $data['deskripsi'] : '') }}">
                    <div class="text-danger">
                        @error('deskripsi')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <h3 class="text-center">Akses Module</h3>
        <div class="table-responsive">
            <table class="table table-hover table-stripped">
                <thead>
                    <tr>
                        <th class="text-center bg-info text-white">Deskripsi</th>
                        <th class="text-center bg-info text-white">Group</th>
                        @foreach ($akses as $akseses)
                            <th class="text-center bg-info text-white">{{ $akseses }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($module as $modules)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" name="module[]" class="form-check-input" value="{{ $modules['id'] }}" {{ (is_array(old('module')) && in_array($modules['id'],old('module'))) || (isset($data) && in_array($modules['id'],collect($data->Module()->get())->pluck('id')->toArray())) ? "checked" : '' }} >
                                    <label class="form-check-label">{{ $modules['deskripsi'] }}</label>
                                </div>
                            </td>
                            <td class="text-center">{{ isset($modules->GroupModule->deskripsi) ? $modules->GroupModule->deskripsi : '' }}</td>
                            @foreach ($akses as $akseses)
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $akseses }}[{{ $modules['id'] }}]" class="form-check-input" {{ (isset(old($akseses)[$modules['id']]) && old($akseses)[$modules['id']] == 'Y') || (isset($data) && isset($data->Module()->find($modules['id'])->pivot->$akseses) && $data->Module()->find($modules['id'])->pivot->$akseses == 'Y') ? 'checked' : '' }} value="Y" >
                                        <label class="form-check-label">{{ $akseses }}</label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn btn-sm {{ isset($action) && $action == "Delete" ? "btn-danger" : "btn-primary" }}" type="submit">{{ isset($action) ? $action : "Submit" }}</button>
    </form>
@endsection