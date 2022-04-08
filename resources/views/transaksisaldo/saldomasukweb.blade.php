@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Penerimaan
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
                    <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                    <th class="bg-info text-white text-center font-weight-bold">Pemberi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $datas['tanggal'] != '' ? date('d-m-Y',strtotime(trim($datas['tanggal']))) : '' }}</td>
                        <td class="text-right">{{ number_format($datas['jumlah']) }}</td>
                        <td>{{ isset($datas->KategoriPemasukan->deskripsi) ? $datas->KategoriPemasukan->deskripsi : '' }}</td>
                        <td>{{ isset($datas->TipePembayaran->deskripsi) ? $datas->TipePembayaran->deskripsi : '' }}</td>
                        <td>{{ $datas['deskripsi'] }}</td>
                        <td>{{ $datas['pemberi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection