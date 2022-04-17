<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use App\Models\ArusKasKeluar;
use App\Models\ArusKasMasuk;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Models\SaldoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ArusKasController extends Controller
{
    private $perPage = 10;

    public function index(Request $request){
        $data = new ArusKas();

        $data = $request->has('kode') && trim($request->input('kode')) != '' ? $data->where('kode','like','%'.trim($request->input('kode')).'%') : $data;
        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;

        return view('aruskas.index',[
            'data' => $data->orderBy('seq')->paginate($this->perPage)->withQueryString()
        ]);
    }

    public function create(){
        return view('aruskas.input',[
            'action' => 'Create'
        ]);
    }

    public function edit($id){
        return view('aruskas.input',[
            'data' => ArusKas::find($id),
            'action' => 'Edit',
            
        ]);
    }

    public function delete($id){
        return view('aruskas.input',[
            'data' => ArusKas::find($id),
            'action' => 'Delete',
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'kode' => 'required|unique:arus_kas,kode',
            'deskripsi' => 'required',
            'seq' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'seq.required' => 'Squence wajib di isi'
        ]);

        try {
            $data = new ArusKas();
            $data->seq = trim($request->input('seq'));
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->save();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'kode' => 'required|unique:arus_kas,kode,'.$id,
            'deskripsi' => 'required',
            'seq' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'seq.required' => 'Squence wajib di isi'
        ]);

        try {
            $data = ArusKas::find($id);
            $data->seq = trim($request->input('seq'));
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function destroy($id){
        try {
            $data = ArusKas::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }

    public function arusKasMasuk($id){
        $data = ArusKas::find($id)->ArusKasMasuks()->orderBy('seq')->get();
        return view('aruskas.aruskasmasuk.index',[
            'data' => $data,
            'id' => $id
        ]);
    }

    public function arusKasMasukCreate($id){
        return view('aruskas.aruskasmasuk.input',[
            'action' => 'Create'
        ]);
    }

    public function arusKasMasukEdit($id){
        return view('aruskas.aruskasmasuk.input',[
            'data' => ArusKasMasuk::find($id),
            'action' => 'Edit'
        ]);
    }

    public function arusKasMasukDelete($id){
        return view('aruskas.aruskasmasuk.input',[
            'data' => ArusKasMasuk::find($id),
            'action' => 'Delete'
        ]);
    }

    public function arusKasMasukStore(Request $request,$id){
        $request->validate([
            'seq' => 'required',
            'deskripsi' => 'required'
        ],[
            'seq.required' => 'Squence wajib di isi',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            ArusKas::find($id)->ArusKasMasuks()->create([
                'seq' => trim($request->input('seq')),
                'deskripsi' => trim($request->input('deskripsi'))
            ]);
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function arusKasMasukUpdate(Request $request,$id){
        $request->validate([
            'seq' => 'required',
            'deskripsi' => 'required'
        ],[
            'seq.required' => 'Squence wajib di isi',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            ArusKasMasuk::find($id)->update([
                'seq' => trim($request->input('seq')),
                'deskripsi' => trim($request->input('deskripsi'))
            ]);
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function  arusKasMasukDestroy($id){
        try {
            $data = ArusKasMasuk::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }

    public function arusKasMasukKategori($id){
        $data = ArusKasMasuk::find($id)->KategoriPemasukans()->get();
        return view('aruskas.aruskasmasuk.kategoripemasukan',[
            'data' => $data,
            'kategoripemasukan' => KategoriPemasukan::whereDoesntHave('ArusKasMasuks')->get(),
            'id' => $id
        ]);
    }

    public function arusKasMasukKategoriPost(Request $request,$id){
        if(!$request->has('kategori_pemasukan_id') || trim($request->input('kategori_pemasukan_id')) == ""){
            return Redirect::back()->with('error','Kategori Pemasukan wajib di isi');
        }
        try {
            ArusKasMasuk::find($id)->KategoriPemasukans()->attach(trim($request->input('kategori_pemasukan_id')));
            return Redirect::back()->with('success','Berhasil');
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal');
        }
    }

    public function arusKasMasukKategoriDestroy($id,$kategoriid){
        try {
            ArusKasMasuk::find($id)->KategoriPemasukans()->detach($kategoriid);
            return Redirect::back()->with('success','Berhasil');
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal');
        }
    }

    public function arusKasKeluar($id){
        $data = ArusKas::find($id)->ArusKasKeluars()->orderBy('seq')->get();
        return view('aruskas.aruskaskeluar.index',[
            'data' => $data,
            'id' => $id
        ]);
    }

    public function arusKasKeluarCreate($id){
        return view('aruskas.aruskaskeluar.input',[
            'action' => 'Create'
        ]);
    }

    public function arusKasKeluarEdit($id){
        return view('aruskas.aruskaskeluar.input',[
            'data' => ArusKasKeluar::find($id),
            'action' => 'Edit'
        ]);
    }

    public function arusKasKeluarDelete($id){
        return view('aruskas.aruskaskeluar.input',[
            'data' => ArusKasKeluar::find($id),
            'action' => 'Delete'
        ]);
    }

    public function arusKasKeluarStore(Request $request,$id){
        $request->validate([
            'seq' => 'required',
            'deskripsi' => 'required'
        ],[
            'seq.required' => 'Squence wajib di isi',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            ArusKas::find($id)->ArusKasKeluars()->create([
                'seq' => trim($request->input('seq')),
                'deskripsi' => trim($request->input('deskripsi'))
            ]);
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function arusKasKeluarUpdate(Request $request,$id){
        $request->validate([
            'seq' => 'required',
            'deskripsi' => 'required'
        ],[
            'seq.required' => 'Squence wajib di isi',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            ArusKasKeluar::find($id)->update([
                'seq' => trim($request->input('seq')),
                'deskripsi' => trim($request->input('deskripsi'))
            ]);
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function  arusKasKeluarDestroy($id){
        try {
            $data = ArusKasKeluar::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }

    public function arusKasKeluarKategori($id){
        $data = ArusKasKeluar::find($id)->KategoriPengeluarans()->get();
        return view('aruskas.aruskaskeluar.kategoripengeluaran',[
            'data' => $data,
            'kategoripengeluaran' => KategoriPengeluaran::whereDoesntHave('ArusKasKeluars')->get(),
            'id' => $id
        ]);
    }

    public function arusKaskeluarKategoriPost(Request $request,$id){
        if(!$request->has('kategori_pengeluaran_id') || trim($request->input('kategori_pengeluaran_id')) == ""){
            return Redirect::back()->with('error','Kategori Pengeluaran wajib di isi');
        }
        try {
            ArusKasKeluar::find($id)->KategoriPengeluarans()->attach(trim($request->input('kategori_pengeluaran_id')));
            return Redirect::back()->with('success','Berhasil');
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal');
        }
    }

    public function arusKasKeluarKategoriDestroy($id,$kategoriid){
        try {
            ArusKasKeluar::find($id)->KategoriPengeluarans()->detach($kategoriid);
            return Redirect::back()->with('success','Berhasil');
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal');
        }
    }

    public function laporan(){
        return view('main.aruskas',[
            'data' => ArusKas::orderBy('seq')->get()
        ]);
    }
    
}
