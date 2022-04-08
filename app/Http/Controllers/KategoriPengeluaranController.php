<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KategoriPengeluaranController extends Controller
{
    private $perPage = 20;

    public function index(Request $request){
        $data = new KategoriPengeluaran();

        $data = $request->has('kode') && trim($request->input('kode')) != '' ? $data->where('kode','like','%'.trim($request->input('kode')).'%') : $data;
        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;

        return view('kategoripengeluaran.index',[
            'data' => $data->paginate($this->perPage)->withQueryString()
        ]);
    }

    public function create(){
        return view('kategoripengeluaran.input',[
            'action' => 'Create'
        ]);
    }

    public function edit($id){
        return view('kategoripengeluaran.input',[
            'data' => KategoriPengeluaran::find($id),
            'action' => 'Edit',
            
        ]);
    }

    public function delete($id){
        return view('kategoripengeluaran.input',[
            'data' => KategoriPengeluaran::find($id),
            'action' => 'Delete',
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'kode' => 'required|unique:kategori_pengeluarans,kode',
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = new KategoriPengeluaran();
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->approval = $request->has('approval') && $request->input('approval') == 'Y'  ? $request->input('approval') : 'N';
            $data->save();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'kode' => 'required|unique:kategori_pengeluarans,kode,'.$id,
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = KategoriPengeluaran::find($id);
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->approval = $request->has('approval') && $request->input('approval') == 'Y'  ? 'Y' : 'N';
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function destroy($id){
        try {
            $data = KategoriPengeluaran::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }
}
