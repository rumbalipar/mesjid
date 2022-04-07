@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Saldo Masuk
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
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $datas['tanggal'] != '' ? date('d-m-Y',strtotime(trim($datas['tanggal']))) : '' }}</td>
                        <td class="text-right">{{ number_format($datas['jumlah']) }}</td>
                        <td>{{ isset($datas->KategoriPemasukan->deskripsi) ? $datas->KategoriPemasukan->deskripsi : '' }}</td>
                        <td>{{ isset($datas->TipePembayaran->deskripsi) ? $datas->TipePembayaran->deskripsi : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#list-{{ $datas['id'] }}">Show / Hide</button>
                        </td>
                        <td colspan="3">
                            <div id="list-{{ $datas['id'] }}" class="collapse">
                                <div class="table-responsive small">
                                    <table class="table table-hover table-stripped">
                                        <thead>
                                            <tr>
                                                <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                                                <th class="bg-info text-white text-center font-weight-bold">Pemberi</th>
                                                <th class="bg-info text-white text-center font-weight-bold">Penerima</th>
                                                <th class="bg-info text-white text-center font-weight-bold">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $datas['deskripsi'] }}</td>
                                                <td>{{ $datas['pemberi'] }}</td>
                                                <td>{{ $datas['penerima'] }}</td>
                                                <td>{{ $datas['keterangan'] }}</td>
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
@endsection