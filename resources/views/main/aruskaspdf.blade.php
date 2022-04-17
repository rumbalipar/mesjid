<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Arus Kas</title>
</head>
<body>
    <h2 style="text-align: center">LAPORAN ARUS KAS</h2>
    <h3 style="text-align: center">{{ isset($applicationcompany->nama) ? $applicationcompany->nama : '' }}</h3>
    <hr style="border:2px solid #000000">
    <h4 style="text-align: center">PERIODE: BULAN {{ date('F Y',strtotime(date('Y-m-d'))) }}</h4>
    <table style="width: 100%">
        <tbody>
            @foreach ($data as $datas)
            <tr>
                <td style="font-weight: bold;">{{ $datas['deskripsi'] }}</td>
                <td></td>
            </tr>
            @if (count($datas->ArusKasMasuks()->orderBy('seq')->get()) > 0)
                @foreach ($datas->ArusKasMasuks()->orderBy('seq')->get() as $arusMasuk)
                    <tr>
                        <td>{{ $arusMasuk->deskripsi }}</td>
                        <td style="text-align: right">{{ number_format($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%;font-size:10px;">
                                <tbody>
                                    @foreach ($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime(date('Y-m-d'))))->get() as $saldoMasuk)
                                        <tr>
                                            <td>- {{ $saldoMasuk['deskripsi'] }}</td>
                                            <td style="text-align: right">{{ number_format($saldoMasuk['jumlah']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td style="font-weight: bold;">Total Penerimaan</td>
                    <td style="font-weight: bold;text-align:right;"><span>{{ number_format($self->penerimaanArusKas($datas->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            @endif

            @if (count($datas->ArusKaskeluars()->orderBy('seq')->get()) > 0)
                @foreach ($datas->ArusKaskeluars()->orderBy('seq')->get() as $arusKeluar)
                    <tr>
                        <td>{{ $arusKeluar->deskripsi }}</td>
                        <td style="text-align: right;">{{ number_format($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width: 100%;font-size:10px;">
                                <tbody>
                                    @foreach ($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime(date('Y-m-d'))))->get() as $saldoKeluar)
                                        <tr>
                                            <td>- {{ $saldoKeluar['deskripsi'] }}</td>
                                            <td style="text-align: right">{{ number_format($saldoKeluar['jumlah']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td style="font-weight: bold;">Total Pengeluaran</td>
                    <td style="font-weight: bold;text-align:right;">{{ number_format($self->pengeluaranArusKas($datas->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            @endif
            @endforeach
            <tr>
                <td><i>Kenaikan/Penurunan Neto Kas dan setara kas</i></td>
                <td style="text-align: right"><i>{{ number_format($self->saldoMonth(date('Y-m-d')) - $self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime(date('Y-m').'-01'))))) }}</i></td>
            </tr>
            <tr>
                <td><i>Kas dan setara kas pada awal bulan</i></td>
                <td style="text-align: right;"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime(date('Y-m').'-01')))) }}</i></td>
            </tr>
            <tr>
                <td><i>Kas dan setara kas pada akhir bulan</i></td>
                <td style="text-align: right;"><i>{{ number_format($self->saldoMonth(date('Y-m-d'))) }}</i></td>
            </tr>
        </tbody>
    </table>

    <pagebreak></pagebreak>

    <h4 style="text-align: center">PERIODE: BULAN {{ date('F Y',strtotime('-1 month',strtotime(date('Y-m-d')))) }}</h4>
    <table style="width: 100%;">
        <tbody>
            @foreach ($data as $datas)
            <tr>
                <td style="font-weight: bold;">{{ $datas['deskripsi'] }}</td>
                <td>&nbsp;</td>
            </tr>
                @if (count($datas->ArusKasMasuks()->orderBy('seq')->get()) > 0)
                    @foreach ($datas->ArusKasMasuks()->orderBy('seq')->get() as $arusMasuk)
                        <tr>
                            <td>{{ $arusMasuk->deskripsi }}</td>
                            <td style="text-align: right">{{ number_format($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width: 100%;font-size:10px;">
                                    <tbody>
                                        @foreach ($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->get() as $saldoMasuk)
                                            <tr>
                                                <td>- {{ $saldoMasuk['deskripsi'] }}</td>
                                                <td style="text-align: right">{{ number_format($saldoMasuk['jumlah']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td style="padding:0px"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="font-weight: bold">Total Penerimaan</td>
                        <td style="text-align: right; font-weight:bold;">{{ number_format($self->penerimaanArusKas($datas->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>
                @endif

                @if (count($datas->ArusKaskeluars()->orderBy('seq')->get()) > 0)
                    @foreach ($datas->ArusKaskeluars()->orderBy('seq')->get() as $arusKeluar)
                        <tr>
                            <td>{{ $arusKeluar->deskripsi }}</td>
                            <td style="text-align: right">{{ number_format($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;font-size:10px;">
                                    <tbody>
                                        @foreach ($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->get() as $saldoKeluar)
                                            <tr>
                                                <td>- {{ $saldoKeluar['deskripsi'] }}</td>
                                                <td style="text-align: right;">{{ number_format($saldoKeluar['jumlah']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="font-weight: bold;">Total Pengeluaran</td>
                        <td style="text-align: right; font-weight:bold;">{{ number_format($self->pengeluaranArusKas($datas->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
                
            @endforeach
            <tr>
                <td><i>Kenaikan/Penurunan Neto Kas dan setara kas</i></td>
                <td style="text-align: right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) - $self->saldoMonth(date('Y-m-d',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) }}</i></td>
            </tr>
            <tr>
                <td><i>Kas dan setara kas pada awal bulan</i></td>
                <td style="text-align: right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) }}</i></td>
            </tr>
            <tr>
                <td><i>Kas dan setara kas pada akhir bulan</i></td>
                <td style="text-align: right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime('-1 month',strtotime(date('Y-m').'-01')))))) }}</i></td>
            </tr>
        </tbody>
    </table>
</body>
</html>