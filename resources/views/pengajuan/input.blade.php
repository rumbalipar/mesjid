@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Pengajuan
@endsection

@section('content')
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                        <input type="text" class="form-control form-control-sm input-sm" name="tanggal" value="{{ old('tanggal',isset($data['tanggal']) && $data['tanggal'] != '' ? date('d-m-Y',strtotime($data['tanggal'])) : date('d-m-Y')) }}" >
                        <span class="input-group-addon"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                    </div>
                    <div class="text-danger">
                        @error('tanggal')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah" class="form-control form-control-sm angka" value="{{ old('jumlah',isset($data['jumlah']) ? $data['jumlah'] : '') }}">
                    <div class="text-danger">
                        @error('jumlah')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipe_pembayaran_id">Tipe Pembayaran</label>
                    <select name="tipe_pembayaran_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value=""></option>
                        @foreach ($tipepembayaran as $tipepembayarans)
                            <option value="{{ $tipepembayarans['id'] }}" {{ old('tipe_pembayaran_id',isset($data['tipe_pembayaran_id']) ? $data['tipe_pembayaran_id'] : '') == $tipepembayarans['id'] ? 'selected' : "" }}>{{ $tipepembayarans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('tipe_pembayaran_id')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_pengeluaran_id">Kategori</label>
                    <select name="kategori_pengeluaran_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value=""></option>
                        @foreach ($kategoripengeluaran as $kategoripengeluarans)
                            <option value="{{ $kategoripengeluarans['id'] }}" {{ old('kategori_pengeluaran_id',isset($data['kategori_pengeluaran_id']) ? $data['kategori_pengeluaran_id'] : '') == $kategoripengeluarans['id'] ? 'selected' : "" }}>{{ $kategoripengeluarans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('kategori_pengeluaran_id')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_pemasukan_id">Sumber</label>
                    <select name="kategori_pemasukan_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value=""></option>
                        @foreach ($kategoripemasukan as $kategoripemasukans)
                            <option value="{{ $kategoripemasukans['id'] }}" {{ old('kategori_pemasukan_id',isset($data['kategori_pemasukan_id']) ? $data['kategori_pemasukan_id'] : '') == $kategoripemasukans['id'] ? 'selected' : "" }}>{{ $kategoripemasukans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('kategori_pemasukan_id')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
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
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control form-control-sm">{{ old('keterangan',isset($data['keterangan']) ? $data['keterangan'] : '') }}</textarea>
                </div>
                <div class="text-danger">
                    @error('keterangan')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <button class="btn btn-sm {{ isset($action) && $action == "Delete" ? "btn-danger" : "btn-primary" }}" type="submit">{{ isset($action) ? $action : "Submit" }}</button>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.input-group.date').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                //startDate: "+1d",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            });
            $('.my-select').selectpicker();
            $('.angka').on('keypress',function(evt){
                return isNumberKey(evt);
            });
        });
    </script>
@endsection