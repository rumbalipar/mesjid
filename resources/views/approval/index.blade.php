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
    Approval <span id="judulStatus">Action</span>
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
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item background-blue-dark border-right border-warning px-2">
            <a class="nav-link text-white active action-history" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Action</a>
        </li>
        <li class="nav-item background-blue-dark border-right border-warning px-2">
            <a class="nav-link text-white action-history" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">History</a>
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
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                                <th class="bg-info text-white text-center font-weight-bold">Action</th>
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
                                @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                                <td class="text-center">
                                    <a href="{{ route('approval.input',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Action">Action</a>
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-{{ $datas['id'] }}">Show / Hide</button>
                                </td>
                                <td colspan="4">
                                    <div id="list-{{ $datas['id'] }}" class="collapse">
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
                                                        <td>{{ $datas['deskripsi'] }}</td>
                                                        <td>{{ $datas['keterangan'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                                @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->ubah == 'Y')
                                <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                            <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                            <th class="bg-info text-white text-center font-weight-bold">Keterangan</th>
                            <th class="bg-info text-white text-center font-weight-bold">Status</th>
                            @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                            <th class="bg-info text-white text-center font-weight-bold">Reset</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $histories)
                            <tr>
                                <td class="text-center">{{ $histories['tanggal'] != '' ? date('d-m-Y',strtotime(trim($histories['tanggal']))) : '' }}</td>
                                <td class="text-right">{{ number_format($histories['jumlah']) }}</td>
                                <td>{{ isset($histories->KategoriPengeluaran->deskripsi) ? $histories->KategoriPengeluaran->deskripsi : '' }}</td>
                                <td>{{ isset($histories->TipePembayaran->deskripsi) ? $histories->TipePembayaran->deskripsi : '' }}</td>
                                <td>{{ isset($histories->KategoriPemasukan->deskripsi) ? $histories->KategoriPemasukan->deskripsi : '' }}</td>
                                <td>{{ $histories['deskripsi'] }}</td>
                                <td>{{ $histories['keterangan'] }}</td>
                                <td class="text-center">
                                    {{ isset($histories->PengajuanStatus->status) ? $histories->PengajuanStatus->status : '' }}<br>
                                </td>
                                @if(\App\Models\User::find(session()->get('sesiuserid'))->GroupUser->Module()->where('route',Route::currentRouteName())->first()->pivot->hapus == 'Y')
                                <td class="text-center">
                                    @if (!isset($histories->SaldoKeluar->id))
                                        <a href="{{ route('approval.reset',['id' => $histories['id']]) }}" class="btn btn-sm btn-danger input" title="Reset Approval">Reset</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-history-{{ $histories['id'] }}">Show / Hide</button>
                                </td>
                                <td colspan="8">
                                    <div id="list-history-{{ $histories['id'] }}" class="collapse">
                                        <div class="row">
                                            <div class="col-md-5">
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
                                                            <tr>
                                                                <td>{{ $histories->PengajuanStatus->tanggal != "" ? date('d-m-Y',strtotime($histories->PengajuanStatus->tanggal)) : '' }}</td>
                                                                <td>{{ $histories->PengajuanStatus->jam }}</td>
                                                                <td>{{ $histories->PengajuanStatus->status }}</td>
                                                                <td>{{ $histories->PengajuanStatus->keterangan }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                @if (isset($histories->SaldoKeluar->id))
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
                                                                    <td class="text-center">{{ $histories->SaldoKeluar->tanggal != '' ? date('d-m-Y',strtotime(trim($histories->SaldoKeluar->tanggal))) : '' }}</td>
                                                                    <td class="text-right">{{ number_format($histories->SaldoKeluar->jumlah) }}</td>
                                                                    <td>{{ isset($histories->SaldoKeluar->KategoriPengeluaran->deskripsi) ? $histories->SaldoKeluar->KategoriPengeluaran->deskripsi : '' }}</td>
                                                                    <td>{{ isset($histories->SaldoKeluar->TipePembayaran->deskripsi) ? $histories->SaldoKeluar->TipePembayaran->deskripsi : '' }}</td>
                                                                    <td>{{ isset($histories->SaldoKeluar->KategoriPemasukan->deskripsi) ? $histories->SaldoKeluar->KategoriPemasukan->deskripsi : '' }}</td>
                                                                    <td>{{ $histories->SaldoKeluar->deskripsi }}</td>
                                                                    <td>{{ $histories->SaldoKeluar->keterangan }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pull-left">
                {{ $history->links() }}
            </div>
            <div class="pull-right">
                Showing 
                {{ $history->firstItem() }}
                to 
                {{ $history->lastItem() }}
                of
                {{ $history->total() }}
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
                $("#judulStatus").text($(this).text());
            });
        });
    </script>
@endsection