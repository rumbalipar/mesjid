@extends('layout.web')

@section('title')
    {{ config('app.name') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">LAPORAN ARUS KAS</h2>
            <h3 class="text-center">{{ isset($applicationcompany->nama) ? $applicationcompany->nama : '' }}</h3>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="order-lg-2 col-sm-12 col-md-6 mb-4">
            <h4 class="text-center">PERIODE: BULAN {{ date('F Y',strtotime(date('Y-m-d'))) }}</h4>
            <div class="table-responsive border border-info rounded">
                <table class="table table-hover table-stripped">
                    <tbody>
                        @foreach ($data as $datas)
                        <tr>
                            <td><span class="font-weight-bold">{{ $datas['deskripsi'] }}</span></td>
                            <td></td>
                        </tr>
                        @if (count($datas->ArusKasMasuks()->orderBy('seq')->get()) > 0)
                            @foreach ($datas->ArusKasMasuks()->orderBy('seq')->get() as $arusMasuk)
                                <tr>
                                    <td><span>{{ $arusMasuk->deskripsi }}</span></td>
                                    <td class="text-right"><a href="#" data-toggle="collapse" data-target="#arusmasuk-{{ $arusMasuk->id }}">{{ number_format($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding:0px">
                                        <div id="arusmasuk-{{ $arusMasuk->id }}" class="collapse">
                                            <div class="table-responsive small">
                                                <table class="table table-hover table-stripped">
                                                    <tbody>
                                                        @foreach ($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime(date('Y-m-d'))))->get() as $saldoMasuk)
                                                            <tr>
                                                                <td>- {{ $saldoMasuk['deskripsi'] }}</td>
                                                                <td class="text-right">{{ number_format($saldoMasuk['jumlah']) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:0px"></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><span class="font-weight-bold">Total Penerimaan</span></td>
                                <td class="text-right font-weight-bold"><span>{{ number_format($self->penerimaanArusKas($datas->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</span></td>
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
                                    <td class="text-right"><a href="#" data-toggle="collapse" data-target="#aruskeluar-{{ $arusKeluar->id }}">{{ number_format($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding:0px">
                                        <div id="aruskeluar-{{ $arusKeluar->id }}" class="collapse">
                                            <div class="table-responsive small">
                                                <table class="table table-hover table-stripped">
                                                    <tbody>
                                                        @foreach ($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime(date('Y-m-d'))))->get() as $saldoKeluar)
                                                            <tr>
                                                                <td>- {{ $saldoKeluar['deskripsi'] }}</td>
                                                                <td class="text-right">{{ number_format($saldoKeluar['jumlah']) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:0px"></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><span class="font-weight-bold">Total Pengeluaran</span></td>
                                <td class="text-right font-weight-bold"><span>{{ number_format($self->pengeluaranArusKas($datas->id,date('m-Y',strtotime(date('Y-m-d'))))->sum('jumlah')) }}</span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                            </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td><i>Kenaikan/Penurunan Neto Kas dan setara kas</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d')) - $self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime(date('Y-m').'-01'))))) }}</i></td>
                        </tr>
                        <tr>
                            <td><i>Kas dan setara kas pada awal bulan</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime(date('Y-m').'-01')))) }}</i></td>
                        </tr>
                        <tr>
                            <td><i>Kas dan setara kas pada akhir bulan</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d'))) }}</i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="order-lg-1 col-sm-12 col-md-6 mb-4">
            <h4 class="text-center">PERIODE: BULAN {{ date('F Y',strtotime('-1 month',strtotime(date('Y-m-d')))) }}</h4>
            <div class="table-responsive table-stripped border border-info rounded">
                <table class="table table-hover">
                    <tbody>
                        @foreach ($data as $datas)
                        <tr>
                            <td><span class="font-weight-bold">{{ $datas['deskripsi'] }}</span></td>
                            <td>&nbsp;</td>
                        </tr>
                            @if (count($datas->ArusKasMasuks()->orderBy('seq')->get()) > 0)
                                @foreach ($datas->ArusKasMasuks()->orderBy('seq')->get() as $arusMasuk)
                                    <tr>
                                        <td><span>{{ $arusMasuk->deskripsi }}</span></td>
                                        <td class="text-right"><a href="#" data-toggle="collapse" data-target="#arusmasuk-{{ $arusMasuk->id }}">{{ number_format($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</a></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0px">
                                            <div id="arusmasuk-{{ $arusMasuk->id }}" class="collapse">
                                                <div class="table-responsive small">
                                                    <table class="table table-hover table-stripped">
                                                        <tbody>
                                                            @foreach ($self->saldoMasukArusKas($arusMasuk->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->get() as $saldoMasuk)
                                                                <tr>
                                                                    <td>- {{ $saldoMasuk['deskripsi'] }}</td>
                                                                    <td class="text-right">{{ number_format($saldoMasuk['jumlah']) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding:0px"></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><span class="font-weight-bold">Total Penerimaan</span></td>
                                    <td class="text-right font-weight-bold"><span>{{ number_format($self->penerimaanArusKas($datas->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</span></td>
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
                                        <td class="text-right"><a href="#" data-toggle="collapse" data-target="#aruskeluar-{{ $arusKeluar->id }}">{{ number_format($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</a></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0px">
                                            <div id="aruskeluar-{{ $arusKeluar->id }}" class="collapse">
                                                <div class="table-responsive small">
                                                    <table class="table table-hover table-stripped">
                                                        <tbody>
                                                            @foreach ($self->saldoKeluarArusKas($arusKeluar->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->get() as $saldoKeluar)
                                                                <tr>
                                                                    <td>- {{ $saldoKeluar['deskripsi'] }}</td>
                                                                    <td class="text-right">{{ number_format($saldoKeluar['jumlah']) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding:0px"></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><span class="font-weight-bold">Total Pengeluaran</span></td>
                                    <td class="text-right font-weight-bold"><span>{{ number_format($self->pengeluaranArusKas($datas->id,date('m-Y',strtotime('-1 month',strtotime(date('Y-m-d')))))->sum('jumlah')) }}</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                            
                        @endforeach
                        <tr>
                            <td><i>Kenaikan/Penurunan Neto Kas dan setara kas</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) - $self->saldoMonth(date('Y-m-d',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) }}</i></td>
                        </tr>
                        <tr>
                            <td><i>Kas dan setara kas pada awal bulan</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 month',strtotime(date('Y-m').'-01'))))) }}</i></td>
                        </tr>
                        <tr>
                            <td><i>Kas dan setara kas pada akhir bulan</i></td>
                            <td class="text-right"><i>{{ number_format($self->saldoMonth(date('Y-m-d',strtotime('-1 day',strtotime('-1 month',strtotime(date('Y-m').'-01')))))) }}</i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection