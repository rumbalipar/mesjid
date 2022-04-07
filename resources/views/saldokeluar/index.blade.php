@extends('layout.index')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Saldo Keluar
@endsection

@section('filter')
    <form action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_dari">Tanggal Dari</label>
                    <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                        <input type="text" class="form-control form-control-sm input-sm" name="tanggal_dari" value="{{ old('tanggal_dari',isset($_GET['tanggal_dari']) && $_GET['tanggal_dari'] != '' ? date('d-m-Y',strtotime($_GET['tanggal_dari'])) : '') }}" >
                        <span class="input-group-addon"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_sampai">Tanggal Sampai</label>
                    <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                        <input type="text" class="form-control form-control-sm input-sm" name="tanggal_sampai" value="{{ old('tanggal_sampai',isset($_GET['tanggal_sampai']) && $_GET['tanggal_sampai'] != '' ? date('d-m-Y',strtotime($_GET['tanggal_sampai'])) : '') }}" >
                        <span class="input-group-addon"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control form-control-sm" value="{{ old('deskripsi',isset($_GET['deskripsi']) ? $_GET['deskripsi'] : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_pengeluaran_id">Kategori Pengeluaran</label>
                    <select name="kategori_pengeluaran_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($kategoripengeluaran as $kategoripemasukans)
                            <option value="{{ $kategoripemasukans['id'] }}" {{ old('kategori_pengeluaran_id',isset($_GET['kategori_pengeluaran_id']) ? $_GET['kategori_pengeluaran_id'] : '') == $kategoripemasukans['id'] ? 'selected' : '' }}>{{ $kategoripemasukans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_pemasukan_id">Kategori Pemasukan</label>
                    <select name="kategori_pemasukan_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($kategoripemasukan as $kategoripemasukans)
                            <option value="{{ $kategoripemasukans['id'] }}" {{ old('kategori_pemasukan_id',isset($_GET['kategori_pemasukan_id']) ? $_GET['kategori_pemasukan_id'] : '') == $kategoripemasukans['id'] ? 'selected' : '' }}>{{ $kategoripemasukans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipe_pembayaran_id">Tipe Pembayaran</label>
                    <select name="tipe_pembayaran_id" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($tipepembayaran as $tipepembayarans)
                            <option value="{{ $tipepembayarans['id']  }}" {{ old('tipe_pembayaran_id',isset($_GET['tipe_pembayaran_id']) ? $_GET['tipe_pembayaran_id'] : '') == $tipepembayarans['id'] ? 'selected' : '' }}>{{ $tipepembayarans['deskripsi'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </form>
@endsection

@section('content')
@if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->buat == 'Y')
<p>
    <a href="{{ route('saldokeluar.create') }}" class="btn btn-sm btn-primary input" title="Create Saldo Keluar">Create</a>
</p>
@endif
<div class="table-responsive small">
    <table class="table table-hover table-stripped">
        <thead>
            <tr>
                <th class="bg-info text-white text-center font-weight-bold">Tanggal</th>
                <th class="bg-info text-white text-center font-weight-bold">Jumlah</th>
                <th class="bg-info text-white text-center font-weight-bold">Kategori</th>
                <th class="bg-info text-white text-center font-weight-bold">Tipe</th>
                <th class="bg-info text-white text-center font-weight-bold">Sumber</th>
                <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                <th class="bg-info text-white text-center font-weight-bold">Keterangan</th>
                @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                <th class="bg-info text-white text-center font-weight-bold">Ubah</th>
                @endif
                @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                <th class="bg-info text-white text-center font-weight-bold">Hapus</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $datas)
                <tr>
                    <td class="text-center">{{ $datas['tanggal'] != '' ? date('d-m-Y',strtotime(trim($datas['tanggal']))) : '' }}</td>
                    <td class="text-right">{{ number_format($datas['jumlah']) }}</td>
                    <td>{{ isset($datas->KategoriPengeluaran->deskripsi) ? $datas->KategoriPengeluaran->deskripsi : '' }}</td>
                    <td>{{ isset($datas->TipePembayaran->deskripsi) ? $datas->TipePembayaran->deskripsi : '' }}</td>
                    <td>{{ isset($datas->KategoriPemasukan->deskripsi) ? $datas->KategoriPemasukan->deskripsi : '' }}</td>
                    <td>{{ $datas['deskripsi'] }}</td>
                    <td>{{ $datas['keterangan'] }}</td>
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                    <td class="text-center">
                        @if ($datas['pengajuan_id'] == null)
                            <a href="{{ route('saldokeluar.edit',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Edit Saldo Keluar">Ubah</a>
                        @endif
                    </td>
                    @endif
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                    <td class="text-center">
                        @if ($datas['pengajuan_id'] == null)
                        <a href="{{ route('saldokeluar.delete',['id' => $datas['id']]) }}" class="btn btn-sm btn-danger input" title="Delete Saldo Keluar">Hapus</a>
                        @endif
                    </td>
                    @endif
                </tr>
                <tr>
                    <td class="text-center">
                        @if ($datas['pengajuan_id'] != null)
                        <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-{{ $datas['id'] }}">Show / Hide</button>
                        @endif
                    </td>
                    <td colspan="6">
                        <div id="list-{{ $datas['id'] }}" class="collapse">
                                @if ($datas['pengajuan_id'] != null)
                                    <h5 class="text-center">Pengajuan</h5>
                                    <div class="table-responsive small">
                                        <table class="table table-hover table-stripped">
                                            <thead>
                                                <tr>
                                                    <th class="bg-info text-white text-center font-weight-bold">Tanggal</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Jumlah</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Kategori</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Tipe</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Sumber</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">{{ $datas->Pengajuan->tanggal != '' ? date('d-m-Y',strtotime(trim($datas->Pengajuan->tanggal))) : '' }}</td>
                                                    <td class="text-right">{{ number_format($datas->Pengajuan->jumlah) }}</td>
                                                    <td>{{ isset($datas->Pengajuan->KategoriPengeluaran->deskripsi) ? $datas->Pengajuan->KategoriPengeluaran->deskripsi : '' }}</td>
                                                    <td>{{ isset($datas->Pengajuan->TipePembayaran->deskripsi) ? $datas->Pengajuan->TipePembayaran->deskripsi : '' }}</td>
                                                    <td>{{ isset($datas->Pengajuan->KategoriPemasukan->deskripsi) ? $datas->Pengajuan->KategoriPemasukan->deskripsi : '' }}</td>
                                                    <td>{{ $datas->Pengajuan->deskripsi }}</td>
                                                    <td>{{ $datas->Pengajuan->keterangan }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                        </div>
                    </td>
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                    <td>&nbsp;</td>
                    @endif
                    @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                    <td>&nbsp;</td>
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
            $('.input-group.date').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                //startDate: "+1d",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            });
            $('.my-select').selectpicker();
        });
    </script>
@endsection