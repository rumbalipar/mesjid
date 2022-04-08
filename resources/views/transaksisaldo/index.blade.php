@extends('layout.index')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Saldo Transaksi
@endsection

@section('filter')
    <form action="" method="get">
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
                    <label for="kategori_pemasukan_id">Kategori</label>
                    <select name="kategori_pemasukan_id" class="form-control form-control-sm" data-live-search="true">
                        <option value="">All</option>
                        @foreach ($kategoripemasukan as $kategoripemasukans)
                            <option value="{{ $kategoripemasukans['id']  }}" {{ old('kategori_pemasukan_id',isset($_GET['kategori_pemasukan_id']) ? $_GET['kategori_pemasukan_id'] : '') == $kategoripemasukans['id'] ? 'selected' : '' }}>{{ $kategoripemasukans['deskripsi'] }}</option>
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
        <a href="{{ route('saldomasuk.create') }}" class="btn btn-sm btn-primary input" title="Create Saldo Masuk">Create Saldo Masuk</a>
        &nbsp;&nbsp;
        <a href="{{ route('saldokeluar.create') }}" class="btn btn-sm btn-primary input" title="Create Saldo Keluar">Create Saldo Keluar</a>
    </p>
    @endif
    <div class="table-responsive">
        <table class="table table-hover table-stripped">
            <thead>
                <tr>
                    <th class="bg-info text-center text-white font-weight-bold">Tanggal</th>
                    <th class="bg-info text-center text-white font-weight-bold">Saldo Awal</th>
                    <th class="bg-info text-center text-white font-weight-bold">Penerimaan</th>
                    <th class="bg-info text-center text-white font-weight-bold">Pengeluaran</th>
                    <th class="bg-info text-center text-white font-weight-bold">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $datas['tanggal'] != "" ? date('d-m-Y',strtotime($datas['tanggal'])) : "" }}</td>
                        <td class="text-right">{{ number_format($self->saldo(date('Y-m-d',strtotime('-1 day',strtotime($datas['tanggal']))),$kategori_pemasukan_id)) }}</td>
                        <td class="text-right">
                            @if ($self->saldoMasuk($datas['tanggal'],$kategori_pemasukan_id) > 0)
                                <a class="input" href="{{ route('transaksisaldo.saldomasuk',['tanggal' => $datas['tanggal'],'kategori_pemasukan_id' => $kategori_pemasukan_id]) }}">{{ number_format($self->saldoMasuk($datas['tanggal'],$kategori_pemasukan_id)) }}</a>
                            @else
                                {{ number_format($self->saldoMasuk($datas['tanggal'],$kategori_pemasukan_id)) }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($self->saldoKeluar($datas['tanggal'],$kategori_pemasukan_id) > 0)
                                <a class="input" href="{{ route('transaksisaldo.saldokeluar',['tanggal' => $datas['tanggal'],'kategori_pemasukan_id' => $kategori_pemasukan_id]) }}">{{ number_format($self->saldoKeluar($datas['tanggal'],$kategori_pemasukan_id)) }}</a>
                            @else
                                {{ number_format($self->saldoKeluar($datas['tanggal'],$kategori_pemasukan_id)) }}
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($self->saldo($datas['tanggal'],$kategori_pemasukan_id)) }}</td>
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
        });
    </script>
@endsection