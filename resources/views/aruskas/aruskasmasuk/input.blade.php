@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Arus Kas Masuk
@endsection

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="seq">Squence</label>
                    <input type="text" name="seq" id="seq" class="form-control form-control-sm angka" value="{{ old('seq',isset($data['seq']) ? $data['seq'] : '') }}">
                    <div class="text-danger">
                        @error('seq')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control form-control-sm angka" value="{{ old('deskripsi',isset($data['deskripsi']) ? $data['deskripsi'] : '') }}">
                    <div class="text-danger">
                        @error('deskripsi')
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
            $('.angka').on('keypress',function(evt){
                return isNumberKey(evt);
            });
        });
    </script>
@endsection