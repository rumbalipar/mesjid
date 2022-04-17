@extends('layout.input')

@section('title')
    {{ config('app.name') }}
@endsection

@section('judul')
    Arus Kas Masuk
@endsection

@section('content')
<p>
    <a href="{{ route('aruskas.aruskasmasuk.create',['id' => $id]) }}" class="btn btn-sm btn-primary input" title="Create Arus Kas Masuk">Create</a>
</p>
    <div class="table-responsive">
        <table class="table table-hover table-stripped">
            <thead>
                <tr>
                    <th class="bg-info text-white text-center font-weight-bold">Sequence</th>
                    <th class="bg-info text-white text-center font-weight-bold">Deskripsi</th>
                    <th class="bg-info text-white text-center font-weight-bold">List Kategori</th>
                    <th class="bg-info text-white text-center font-weight-bold">Kategori Pemasukan</th>
                    <th class="bg-info text-white text-center font-weight-bold">Ubah</th>
                    <th class="bg-info text-white text-center font-weight-bold">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $datas['seq'] }}</td>
                        <td>{{ $datas['deskripsi'] }}</td>
                        <td class="text-center">{!! implode('<br>',collect($datas->KategoriPemasukans()->get())->pluck('deskripsi')->toArray()) !!}</td>
                        <td class="text-center">
                            <a href="{{ route('aruskas.aruskasmasuk.kategoripemasukan',['id' => $datas['id']]) }}" class="btn btn-sm btn-secondary input" title="Kategori Pemasukan">Kategori Pemasukan</a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('aruskas.aruskasmasuk.edit',['id' => $datas['id']]) }}" class="btn btn-sm btn-primary input" title="Edit Arus Kas Masuk">Ubah</a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('aruskas.aruskasmasuk.delete',['id' => $datas['id']]) }}" class="btn btn-sm btn-danger input" title="Delete Arus Kas Masuk">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="modal-title">Title</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span class="text-white" aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">     
                <iframe id="modal-body" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(".input").on('click',function(){
                openModal(this.title,this.href);
                return false;
            });

            $('.input').on('hidden.bs.modal', function () {
                window.location.href = window.location.href;
            });
        });
    </script>
@endsection