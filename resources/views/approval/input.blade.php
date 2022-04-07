@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Approval
@endsection

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">--</option>
                        @foreach ($status as $statuses)
                            <option value="{{ $statuses }}"{{ old('status',isset($data->PengajuanStatus->status) ? $data->PengajuanStatus->status : '' ) == $statuses ? 'selected' : '' }}>{{ $statuses }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('status')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="keterangan">Catatan</label>
                    <textarea name="keterangan" class="form-control form-control-sm">{{ old('keterangan',isset($data->PengajuanStatus->keterangan) ? $data->PengajuanStatus->keterangan : '') }}</textarea>
                </div>
                <div class="text-danger">
                    @error('keterangan')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <button class="btn btn-sm {{ isset($action) && $action == "Reset" ? "btn-danger" : "btn-primary" }}" type="submit">{{ isset($action) ? $action : "Submit" }}</button>
    </form>
@endsection