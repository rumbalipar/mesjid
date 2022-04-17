@extends('layout.web')

@section('title')
    {{ config('app.name') }}
@endsection

@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <a href="{{ route('laporan.month',['periode' => date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d',strtotime('01-'.$month.'-'.$year))))) ]) }}" class="btn btn-sm btn-primary float-left text-white">Previous Month</a>
            @if(strtotime($year.'-'.$month.'-01') < strtotime(date('Y-m').'-01'))
            <a href="{{ route('laporan.month',['periode' => date('m-Y',strtotime('+1 month',strtotime(date('Y-m-d',strtotime('01-'.$month.'-'.$year))))) ]) }}" class="btn btn-sm btn-primary float-right text-white">Next Month</a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-8 bg-info pb-4 mt-2">
            <h2 class="text-center font-weight-bold text-white py-2">Laporan Keuangan Bulan {{ $bulan.' '.$year }}</h2>
            <div class="table-responsive bg-white">
                <table class="table table-hover table-stripped">
                    <tbody>
                        @foreach ($kategoripemasukan as $kategoripemasukans)
                            @if($kategoripemasukans->SaldoMasuks()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah') > 0)
                            <tr>
                                <td><span class="font-weight-bold">{{ $kategoripemasukans['deskripsi'] }}</span></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 0px;">
                                    <div id="kategoripemasukan-{{ $kategoripemasukans['id'] }}" class="collapse">
                                        <div class="table-responsive small">
                                            <table class="table table-hover table-stripped">
                                                <tbody>
                                                    @foreach ($kategoripemasukans->SaldoMasuks()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->get() as $saldoMasuk)
                                                        <tr>
                                                            <td>{{ $saldoMasuk['deskripsi'] }}</td>
                                                            <td class="text-right">{{ number_format($saldoMasuk['jumlah']) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 0px;">

                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><span class="font-weight-bold">Total Penerimaan</span></td>
                                <td class="text-right"><a class="font-weight-bold" href="#" data-toggle="collapse" data-target="#kategoripemasukan-{{ $kategoripemasukans['id'] }}">{{ number_format($kategoripemasukans->SaldoMasuks()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah')) }}</a></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach ($kategoripengeluaran as $kategoripengeluarans)
                            @if ($kategoripengeluarans->saldoKeluars()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah') > 0)
                                <tr>
                                    <td><span class="font-weight-bold">{{ $kategoripengeluarans['deskripsi'] }}</span></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 0px;">
                                        <div id="kategoripengeluaran-{{ $kategoripengeluarans['id'] }}" class="collapse">
                                            <div class="table-responsive small">
                                                <table class="table table-hover table-stripped">
                                                    <tbody>
                                                        @foreach ($kategoripengeluarans->saldoKeluars()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->get() as $saldoKeluar)
                                                            <td>{{ $saldoKeluar->deskripsi }}</td>
                                                            <td class="text-right">{{ number_format($saldoKeluar->jumlah) }}</td>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 0px;"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><span class="font-weight-bold">Total Pengeluaran</span></td>
                                    <td class="text-right"><a class="font-weight-bold" href="#" data-toggle="collapse" data-target="#kategoripengeluaran-{{ $kategoripengeluarans['id'] }}">{{ number_format($kategoripengeluarans->saldoKeluars()->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah')) }}</a></td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Kenaikan/Penurunan Neto Kas dan setara kas</td>
                            <td>&nbsp;</td>
                            <td class="text-right font-weight-bold">{{ number_format($saldoakhir - $saldoawal) }}</td>
                        </tr>
                        <tr>
                            <td>Kas dan setara kas pada awal bulan</td>
                            <td>&nbsp;</td>
                            <td class="text-right font-weight-bold">{{ number_format($saldoawal) }}</td>
                        </tr>
                        <tr>
                            <td>Kas dan setara kas pada akhir bulan</td>
                            <td>&nbsp;</td>
                            <td class="text-right font-weight-bold">{{ number_format($saldoakhir) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection