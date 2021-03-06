@extends('layout.web')

@section('title')
    Aplikasi Mesjid
@endsection

@section('css')
<style>
    .modal {
        padding: 0 !important; // override inline padding-right added from js
    }

    .modal .modal-dialog {
        width: 90%;
        max-width: none;
        height: 100%;
        margin: 0;
    }

    .modal .modal-content {
        height: 90%;
        border: 0;
        border-radius: 0;
    }

    .modal .modal-body {
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="row border border-info rounded py-2">
    <div class="col-12">
        <div class="judul-tutorial text-center">
            <span class="h2 font-weight-bold"> Cara Melihat History Kas</span>
        </div>
    </div>
    <div class="col-12">
        <div class="row text-center font-weight-bold">
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/pilih-tanggal.png" class="img-fluid" alt="" style="max-height: 96px">
                &nbsp;<i class="fa fa-arrow-right"></i><br>
                Masukkan Tanggal dari dan sampai
            </div>
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/select.png" class="img-fluid" alt="" style="max-height: 96px">
                &nbsp;<i class="fa fa-arrow-right"></i><br>
                Pilih Kategori
            </div>
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/show.png" class="img-fluid" alt="" style="max-height: 96px">
                <br>
                Klik Tombol Show
            </div>
        </div>
    </div>
</div>

<div class="row mt-2 bg-info border border-primary rounded">
    <div class="col-12 text-center text-white font-weight-bold mt-2">
        <span class="h2">Kas {{ isset($applicationcompany['nama']) ? $applicationcompany['nama'] : '' }}</span>
    </div>
    <div class="col-12 mt-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_dari" class="text-white">Tanggal Dari</label>
                        <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                            <input type="text" class="form-control form-control-sm input-sm" id="tanggal_dari" name="tanggal_dari" value="{{ old('tanggal_dari',isset($_GET['tanggal_dari']) && $_GET['tanggal_dari'] != '' ? date('d-m-Y',strtotime($_GET['tanggal_dari'])) : date('d-m-Y')) }}" >
                            <span class="input-group-addon"><button class="btn btn-warning btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_sampai" class="text-white">Tanggal Sampai</label>
                        <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                            <input type="text" class="form-control form-control-sm input-sm" id="tanggal_sampai" name="tanggal_sampai" value="{{ old('tanggal_sampai',isset($_GET['tanggal_sampai']) && $_GET['tanggal_sampai'] != '' ? date('d-m-Y',strtotime($_GET['tanggal_sampai'])) : date('d-m-Y')) }}" >
                            <span class="input-group-addon"><button class="btn btn-warning btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kategori_pemasukan_id" class="text-white">Kategori</label>
                        <select name="kategori_pemasukan_id" class="form-control form-control-sm" data-live-search="true">
                            <option value="">All</option>
                            @foreach ($kategoripemasukan as $kategoripemasukans)
                                <option value="{{ $kategoripemasukans['id']  }}" {{ old('kategori_pemasukan_id',isset($_GET['kategori_pemasukan_id']) ? $_GET['kategori_pemasukan_id'] : '') == $kategoripemasukans['id'] ? 'selected' : '' }}>{{ $kategoripemasukans['deskripsi'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mb-2">
                    <button type="submit" class="btn btn-sm btn-warning px-5 font-weight-bold">Show</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row border border-black rounded">
    <div class="col-12 mt-2 bg-secondary text-center font-weight-bold py-2 text-white">
        <span>Kas Perode {{ isset($tanggal_dari) && $tanggal_dari != "" ? date('d F Y',strtotime($tanggal_dari)) : "" }} s/d {{ isset($tanggal_sampai) && $tanggal_sampai != "" ? date('d F Y',strtotime($tanggal_sampai)) : "" }}</span>&nbsp;
        <span>{{ isset($kategori) && $kategori != '' ? 'Kategori '.$kategori : 'Semua Kategori' }}</span>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mt-2">
        <div class="col bg-primary text-white px-2 py-1 text-right">
            <h3 class="text-center font-weight-bold">Saldo Awal</h3>
            <h4 class="text-right">{{ number_format($saldoawal) }}</h4>
            <span class="small font-weight-bold">{{ date('d-m-Y',strtotime($tanggal_dari)) }}</span>
        </div>
    </div>
    <div class="col-md-3 mt-2">
        <div class="col bg-success text-white px-2 py-1 text-right">
            <h3 class="text-center font-weight-bold">Penerimaan</h3>
            <h4 class="text-right">{{ number_format($saldomasuk) }}</h4>
            <span class="small font-weight-bold">{{ date('d-m-Y',strtotime($tanggal_dari)) }} s/d {{ date('d-m-Y',strtotime($tanggal_sampai)) }}</span>
        </div>
    </div>
    <div class="col-md-3 mt-2">
        <div class="col bg-danger text-white px-2 py-1 text-right">
            <h3 class="text-center font-weight-bold">Pengeluaran</h3>
            <h4 class="text-right">{{ number_format($saldokeluar) }}</h4>
            <span class="small font-weight-bold">{{ date('d-m-Y',strtotime($tanggal_dari)) }} s/d {{ date('d-m-Y',strtotime($tanggal_sampai)) }}</span>
        </div>
    </div>
    <div class="col-md-3 mt-2">
        <div class="col bg-warning text-white px-2 py-1 text-right">
            <h3 class="text-center font-weight-bold">Saldo Akhir</h3>
            <h4 class="text-right">{{ number_format($saldoakhir) }}</h4>
            <span class="small font-weight-bold">{{ date('d-m-Y',strtotime($tanggal_sampai)) }}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mt-2">
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
                                    <a class="input" href="{{ route('transaksisaldo.saldomasuk.web',['tanggal' => $datas['tanggal'],'kategori_pemasukan_id' => $kategori_pemasukan_id]) }}">{{ number_format($self->saldoMasuk($datas['tanggal'],$kategori_pemasukan_id)) }}</a>
                                @else
                                    {{ number_format($self->saldoMasuk($datas['tanggal'],$kategori_pemasukan_id)) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($self->saldoKeluar($datas['tanggal'],$kategori_pemasukan_id) > 0)
                                    <a class="input" href="{{ route('transaksisaldo.saldokeluar.web',['tanggal' => $datas['tanggal'],'kategori_pemasukan_id' => $kategori_pemasukan_id]) }}">{{ number_format($self->saldoKeluar($datas['tanggal'],$kategori_pemasukan_id)) }}</a>
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
    </div>
</div>

<div class="modal fade" id="modal-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="modal-title">Title</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span class="text-white" aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">     
                <iframe id="modal-body" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $(".input").on('click',function(){
            openModal(this.title,this.href);
            return false;
       });
       $('form').on('submit',function(e){
           //e.preventDefault();
           if($("#tanggal_dari").val() == ""){
                swal({
                    title: "Warning",
                    text: "Periode tanggal dari tidak boleh kosong",
                    icon: "warning",
                    buttons: 'Ok!',
                    dangerMode: false,
                }).then(() => $("#tanggal_dari").focus() );
                return false;
           }
           if($("#tanggal_sampai").val() == ""){
                swal({
                    title: "Warning",
                    text: "Periode tanggal sampai tidak boleh kosong",
                    icon: "warning",
                    buttons: 'Ok!',
                    dangerMode: false,
                }).then(() => $("#tanggal_sampai").focus() );
                return false;
           }
           //var form = $(this);

           return true;
       });
    });
</script>
@endsection