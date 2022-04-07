@extends('layout.index')

@section('title')
    {{ config('app.name') }}
@endsection

@section('css')
<style>
    .nav-pills .nav-link.active{
        background-color: #0D2F50;
    }
</style>
@endsection

@section('judul')
    Pengajuan <span id="actionJudul"></span>
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
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Pengajuan Status</label>
                    <select name="status" class="form-control form-control-sm my-select" data-live-search="true">
                        <option value="">ALL</option>
                        @foreach ($status as $statuses)
                            <option value="{{ $statuses }}" {{ isset($_GET['status']) && $_GET['status'] == $statuses ? "selected" : "" }}>{{ $statuses }}</option>
                        @endforeach
                        <option value="Not Response" {{ isset($_GET['status']) && $_GET['status'] == "Not Response" ? "selected" : "" }}>Not Response</option>
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
    <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary input" title="Create Pengajuan">Create</a>
</p>
@endif
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item background-blue-dark border-right border-warning px-2">
        <a class="nav-link text-white active action-history" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All</a>
    </li>
    <li class="nav-item background-blue-dark border-right border-warning px-2">
        <a class="nav-link text-white action-history" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">Action</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                        <th class="bg-info text-white text-center font-weight-bold">Status</th>
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                        <th class="bg-info text-white text-center font-weight-bold">Proses</th>
                        @endif
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
                            <td class="text-center">
                                @if(isset($datas->PengajuanStatus->status))
                                    {{ $datas->PengajuanStatus->status }}<br>
                                @endif
                            </td>
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                            <td class="text-center">
                                @if (isset($datas->PengajuanStatus->status) && $datas->PengajuanStatus->status == 'Approve' && !isset($datas->SaldoKeluar->id))
                                    <a href="{{ route('pengajuan.proses',['id' => $datas['id']]) }}" class="btn btn-sm btn-warning input" title="Proses Pengajuan">Proses</a>
                                @endif
                            </td>
                            @endif
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                            <td class="text-center">
                                @if(!isset($datas->PengajuanStatus->status))
                                    <a href="{{ route('pengajuan.edit',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Edit Pengajuan">Ubah</a>
                                @endif
                            </td>
                            @endif
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                            <td class="text-center">
                                <a href="{{ route('pengajuan.delete',['id' => $datas['id']]) }}" class="btn btn-sm btn-danger input" title="Delete Pengajuan">Hapus</a>
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-{{ $datas['id'] }}">Show / Hide</button>
                            </td>
                            <td colspan="8">
                                <div id="list-{{ $datas['id'] }}" class="collapse">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if (isset($datas->PengajuanStatus->status))
                                                <h4 class="text-center">Approval</h4>
                                                <div class="table-responsive small">
                                                    <table class="table table-hover table-stripped">
                                                        <thead>
                                                            <tr>
                                                                <th class="bg-info text-white text-center font-weight-bold">Tanggal</th>
                                                                <th class="bg-info text-white text-center font-weight-bold">Jam</th>
                                                                <th class="bg-info text-white text-center font-weight-bold">Status</th>
                                                                <th class="bg-info text-white text-center font-weight-bold">Catatan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $datas->PengajuanStatus->tanggal != "" ? date('d-m-Y',strtotime($datas->PengajuanStatus->tanggal)) : '' }}</td>
                                                                    <td>{{ $datas->PengajuanStatus->jam }}</td>
                                                                    <td>{{ $datas->PengajuanStatus->status }}</td>
                                                                    <td>{{ $datas->PengajuanStatus->keterangan }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            @if (isset($datas->SaldoKeluar->id))
                                                <h4 class="text-center">Saldo Keluar</h4>
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
                                                                <td class="text-center">{{ $datas->SaldoKeluar->tanggal != '' ? date('d-m-Y',strtotime(trim($datas->SaldoKeluar->tanggal))) : '' }}</td>
                                                                <td class="text-right">{{ number_format($datas->SaldoKeluar->jumlah) }}</td>
                                                                <td>{{ isset($datas->SaldoKeluar->KategoriPengeluaran->deskripsi) ? $datas->SaldoKeluar->KategoriPengeluaran->deskripsi : '' }}</td>
                                                                <td>{{ isset($datas->SaldoKeluar->TipePembayaran->deskripsi) ? $datas->SaldoKeluar->TipePembayaran->deskripsi : '' }}</td>
                                                                <td>{{ isset($datas->SaldoKeluar->KategoriPemasukan->deskripsi) ? $datas->SaldoKeluar->KategoriPemasukan->deskripsi : '' }}</td>
                                                                <td>{{ $datas->SaldoKeluar->deskripsi }}</td>
                                                                <td>{{ $datas->SaldoKeluar->keterangan }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
    </div>

    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="table-responsive small">
            <table class="table table-hover table-stripped">
                <thead>
                    <tr>
                        <th class="bg-info text-white text-center font-weight-bold">Tanggal</th>
                        <th class="bg-info text-white text-center font-weight-bold">Jumlah</th>
                        <th class="bg-info text-white text-center font-weight-bold">Kategori</th>
                        <th class="bg-info text-white text-center font-weight-bold">Tipe</th>
                        <th class="bg-info text-white text-center font-weight-bold">Sumber</th>
                        <th class="bg-info text-white text-center font-weight-bold">Status</th>
                        @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                        <th class="bg-info text-white text-center font-weight-bold">Proses</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataaction as $dataactions)
                        <tr>
                            <td class="text-center">{{ $dataactions['tanggal'] != '' ? date('d-m-Y',strtotime(trim($dataactions['tanggal']))) : '' }}</td>
                            <td class="text-right">{{ number_format($dataactions['jumlah']) }}</td>
                            <td>{{ isset($dataactions->KategoriPengeluaran->deskripsi) ? $dataactions->KategoriPengeluaran->deskripsi : '' }}</td>
                            <td>{{ isset($dataactions->TipePembayaran->deskripsi) ? $dataactions->TipePembayaran->deskripsi : '' }}</td>
                            <td>{{ isset($dataactions->KategoriPemasukan->deskripsi) ? $dataactions->KategoriPemasukan->deskripsi : '' }}</td>
                            <td class="text-center">
                                @if(isset($dataactions->PengajuanStatus->status))
                                    {{ $dataactions->PengajuanStatus->status }}<br>
                                    {{ date('d-m-Y',strtotime($dataactions->PengajuanStatus->tanggal)) }}<br>
                                    {{ $dataactions->PengajuanStatus->jam }}
                                @endif
                            </td>
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                            <td class="text-center">
                                @if (isset($dataactions->PengajuanStatus->status) && $dataactions->PengajuanStatus->status == 'Approve' && !isset($dataactions->SaldoKeluar->id))
                                    <a href="{{ route('pengajuan.proses',['id' => $dataactions['id']]) }}" class="btn btn-sm btn-warning input" title="Proses Pengajuan">Proses</a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-action{{ $dataactions['id'] }}">Show / Hide</button>
                            </td>
                            <td colspan="5">
                                <div id="list-action{{ $dataactions['id'] }}" class="collapse">
                                    <div class="table-responsive small">
                                        <table class="table table-hover table-stripped">
                                            <thead>
                                                <tr>
                                                    <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                                                    <th class="bg-info text-white text-center font-weight-bold">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $dataactions['deskripsi'] }}</td>
                                                    <td>{{ $dataactions['keterangan'] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
            $(".action-history").on("click",function(){
                $("#actionJudul").text($(this).text());
            });
        });
    </script>
@endsection