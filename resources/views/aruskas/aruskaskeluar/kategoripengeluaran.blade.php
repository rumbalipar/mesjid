@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Kategori Pengeluaran
@endsection

@section('content')
    <form action="{{ route('aruskas.aruskaskeluar.kategoripengeluaran.post',['id' => $id]) }}" method="post" class="form-inline">
        @csrf
        <label class="sr-only" for="kategori_pengeluaran_id">Kategori Pengeluaran</label>
        <select name="kategori_pengeluaran_id" id="kategori_pengeluaran_id" class="form-control form-control-sm mb-2 mr-sm-2 my-select" data-live-search="true">
            <option value="">--</option>
            @foreach ($kategoripengeluaran as $kategoripengeluarans)
                <option value="{{ $kategoripengeluarans['id'] }}">{{ $kategoripengeluarans['deskripsi'] }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary mb-2">Tambah</button>
    </form>
    <div class="table-responsive">
        <table class="table table-hover table-stripped">
            <thead>
                <tr>
                    <th class="bg-info text-white text-center forn-weight-bold">Kode</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Deskripsi</th>
                    <th class="bg-info text-white text-center forn-weight-bold">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                <td class="text-center">{{ $datas['kode'] }}</td>
                <td>{{ $datas['deskripsi'] }}</td>
                <td>
                    <form method="POST" action="{{ route('aruskas.aruskaskeluar.kategoripengeluaran.destroy',['id' => $id,'kategoriid' => $datas['id']]) }}" class="form-delete">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(".form-delete").on("submit",function(e){
                e.preventDefault();
                var form = this;
                confirmDelete(form);
            });

            $(".my-select").selectpicker();
        });
    </script>
@endsection