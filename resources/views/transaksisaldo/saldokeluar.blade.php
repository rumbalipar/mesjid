@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Saldo Keluar
@endsection

@section('content')
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
                @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $datas['tanggal'] != '' ? date('d-m-Y',strtotime(trim($datas['tanggal']))) : '' }}</td>
                        <td class="text-right">{{ number_format($datas['jumlah']) }}</td>
                        <td>{{ isset($datas->KategoriPengeluaran->deskripsi) ? $datas->KategoriPengeluaran->deskripsi : '' }}</td>
                        <td>{{ isset($datas->TipePembayaran->deskripsi) ? $datas->TipePembayaran->deskripsi : '' }}</td>
                        <td>{{ isset($datas->KategoriPemasukan->deskripsi) ? $datas->KategoriPemasukan->deskripsi : '' }}</td>
                        <td>{{ $datas['deskripsi'] }}</td>
                        <td>{{ $datas['keterangan'] }}</td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection