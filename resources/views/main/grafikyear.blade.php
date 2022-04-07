@extends('layout.web')

@section('title')
    Grafik Tahunan
@endsection

@section('content')
<div class="row">
    <div class="col-12 mt-2">
        <div class="card card-info">
            <div class="card-header bg-info text-white text-center font-weight-bold">
                <span>Periode</span>
            </div>
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dari">Dari</label>
                                <select name="dari" class="form-control form-control-sm myselect" data-live-search="true">
                                    @for ($i = date('Y'); $i > (date('Y') - 10); $i--)
                                        <option value="{{ $i }}" {{ old('dari',isset($dari) ? $dari : '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sampai">Sampai</label>
                                <select name="sampai" class="form-control form-control-sm myselect" data-live-search="true">
                                    @for ($i = date('Y'); $i > (date('Y') - 10); $i--)
                                        <option value="{{ $i }}" {{ old('sampai',isset($sampai) ? $sampai : '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-sm btn-primary px-5 font-weight-bold">Show</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h2 class="text-center">Grafik Periode {{ $periode }}</h2> 
    </div>
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

       $('.myselect').selectpicker();

       showChart();
   });

   function showChart(){
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
           label: 'Saldo Masuk',
           data: saldomasuk,
           backgroundColor: 'rgba(0, 99, 132, 0.6)',
           borderColor: 'rgba(0, 99, 132, 1)',
           yAxisID: "y-axis-density"
       };

       var saldoKeluarData = {
           label: 'Saldo Keluar',
           data: saldokeluar,
           backgroundColor: 'rgba(99, 132, 0, 0.6)',
           borderColor: 'rgba(99, 132, 0, 1)',
           yAxisID: "y-axis-gravity"
       };

       var transaksiData = {
           labels: label,
           datasets: [saldoMasukData, saldoKeluarData]
       };

       var chartOptions = {
           legend: {
               display: true
           },
           title: {
               display: true,
               text: "{{ $periode }}"
           }
       };
           
       var barChart = new Chart(myChart, {
           type: 'bar',
           data: transaksiData,
           options: chartOptions
       });
   }
</script>
@endsection