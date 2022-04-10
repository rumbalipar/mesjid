@extends('layout.web')

@section('title')
    Aplikasi Mesjid
@endsection

@section('content')
<div class="row border border-info rounded py-2">
    <div class="col-12">
        <div class="judul-tutorial text-center">
            <span class="h2 font-weight-bold">Cara Menampilkan Grafik</span>
        </div>
    </div>
    <div class="col-12">
        <div class="row text-center font-weight-bold">
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/pilih-tanggal.png" class="img-fluid img-thumbnail" alt="" style="max-height: 96px">
                &nbsp;<i class="fa fa-arrow-right"></i><br>
                Masukkan Bulan dari dan sampai
            </div>
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/select.png" class="img-fluid img-thumbnail" alt="" style="max-height: 96px">
                &nbsp;<i class="fa fa-arrow-right"></i><br>
                Pilih Kategori
            </div>
            <div class="col-4">
                <img src="{{ url('/') }}/assets/images/show.png" class="img-fluid img-thumbnail" alt="" style="max-height: 96px">
                <br>
                Klik Tombol Show
            </div>
        </div>
    </div>
</div>

<div class="row mt-2 bg-info border border-primary rounded">
    <div class="col-12 text-center text-white font-weight-bold mt-2">
        <span class="h2">Grafik Bulanan {{ isset($applicationcompany['nama']) ? $applicationcompany['nama'] : '' }}</span>
    </div>
    <div class="col-12 mt-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_dari" class="text-white">Bulan Dari</label>
                        <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                            <input type="text" class="form-control form-control-sm input-sm" id="dari" name="dari" value="{{ old('dari',$dari) }}" >
                            <span class="input-group-addon"><button class="btn btn-warning btn-sm" type="button"><i class="fa fa-calendar"></i></button></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_sampai" class="text-white">Bulan Sampai</label>
                        <div class="input-group date" data-date-format="dd-mm-yyyy" data-provide="datepicker">
                            <input type="text" class="form-control form-control-sm input-sm" id="sampai" name="tanggal_sampai" value="{{ old('sampai',$sampai) }}" >
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
        <span>Grafik Periode {{ $periode }}</span>&nbsp;
        <span>{{ isset($kategori) && $kategori != '' ? 'Kategori '.$kategori : 'Semua Kategori' }}</span>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <canvas id="myChart" style="width:100%"></canvas>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('.input-group.date').datepicker({
            format: "mm-yyyy",
            startView: "months", 
            minViewMode: "months"
        });

        showChart();
    });

    function showChart(){
        Chart.register(ChartDataLabels);
        var grafik = ({!! $grafik !!});
        var label = []
        var saldomasuk = [];
        var saldokeluar = [];
        for(var i = 0; i < grafik.length;i++){
            label.push(grafik[i].label);
            saldomasuk.push(grafik[i].saldomasuk);
            saldokeluar.push(grafik[i].saldokeluar);
        }

        var myChart = document.getElementById("myChart");

        var saldoMasukData = {
            label: 'Penerimaan',
            data: saldomasuk,
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderColor: 'rgba(0, 99, 132, 1)',
            yAxisID: "y-axis-density",
            datalabels: {
                display: true,
            }
        };

        var saldoKeluarData = {
            label: 'Pengeluaran',
            data: saldokeluar,
            backgroundColor: 'rgba(220,20,60, 0.6)',
            borderColor: 'rgba(220,20,60, 1)',
            yAxisID: "y-axis-gravity",
            datalabels: {
                display: true,
            }
        };

        var transaksiData = {
            labels: label,
            datasets: [saldoMasukData, saldoKeluarData]
        };

        var chartOptions = {
            legend: {
                display: true
            },
            
            plugins: {
                    title: {
                        display: true,
                        text: '{{ $periode }}'
                    },
                    datalabels: {
                        display: true,
                        color: 'black',
                        align : 'top',
                        labels: {
                            title: {
                                font: {
                                    weight: 'bold'
                                },
                                
                             },
                            value: {
                                color: 'green'
                            }
                        }
                    },
                },
        };
            
        var barChart = new Chart(myChart, {
            type: 'bar',
            data: transaksiData,
            options: chartOptions
        });
    }
</script>
@endsection