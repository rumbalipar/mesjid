@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Kategori Pemasukan
@endsection

@section('content')
    <form action="{{ route('aruskas.aruskasmasuk.kategoripemasukan.post',['id' => $id]) }}" method="post" class="form-inline">
        @csrf
        <label class="sr-only" for="kategori_pemasukan_id">Kategori Pemasukan</label>
        <select name="kategori_pemasukan_id" id="kategori_pemasukan_id" class="form-control form-control-sm mb-2 mr-sm-2 my-select" data-live-search="true">
            <option value="">--</option>
            @foreach ($kategoripemasukan as $kategoripemasukans)
                <option value="{{ $kategoripemasukans['id'] }}">{{ $kategoripemasukans['deskripsi'] }}</option>
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
                <tr>
                    <td class="text-center">{{ $datas['kode'] }}</td>
                    <td>{{ $datas['deskripsi'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('aruskas.aruskasmasuk.kategoripemasukan.destroy',['id' => $id,'kategoriid' => $datas['id']]) }}" class="form-delete">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
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