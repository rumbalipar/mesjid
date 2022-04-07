<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Models\Pengajuan;
use App\Models\PengajuanStatus;
use App\Models\TipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PengajuanController extends Controller
{
    private $perPage = 20;

    public function index(Request $request){
        $data = new Pengajuan();

        $tangga_dari = $request->has('tanggal_dari') && trim($request->input('tanggal_dari')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_dari')))) : "";
        $tangga_sampai = $request->has('tanggal_sampai') && trim($request->input('tanggal_sampai')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_sampai')))) : "";

        if($tangga_dari != "" && $tangga_sampai != ""){
            $data = $data->whereDate('tanggal','>=',$tangga_dari)->whereDate('tanggal','<=',$tangga_sampai);
        }elseif($tangga_dari != "" && $tangga_sampai == ""){
            $data = $data->whereDate('tanggal','>=',$tangga_dari);
        }elseif($tangga_dari == "" && $tangga_sampai != ""){
            $data = $data->whereDate('tanggal','<=',$tangga_sampai);
        }

        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;
        $data = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != '' ? $data->where('kategori_pemasukan_id',trim($request->input('kategori_pemasukan_id'))) : $data;
        $data = $request->has('tipe_pembayaran_id') && trim($request->input('tipe_pembayaran_id')) != '' ? $data->where('tipe_pembayaran_id',trim($request->input('tipe_pembayaran_id'))) : $data;
        $data = $request->has('kategori_pengeluaran_id') && trim($request->input('kategori_pengeluaran_id')) != '' ? $data->where('kategori_pengeluaran_id',trim($request->input('kategori_pengeluaran_id'))) : $data;

        if($request->has('status') && trim($request->input('status')) != ""){
            switch (trim($request->input('status'))) {
                case 'Not Response':
                   $data = $data->doesntHave('PengajuanStatus');
                    break;
                
                default:
                    $data = $data->whereHas('PengajuanStatus',function($pengajuanStatus) use($request){
                        return $pengajuanStatus->where('status',trim($request->input('status')));
                    });
                    break;
            }
        }

        return view('pengajuan.index',[
            'data' => $data->orderBy('tanggal','desc')->orderBy('id','desc')->paginate($this->perPage)->withQueryString(),
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
            'status' => PengajuanStatus::$status,
            'dataaction' => Pengajuan::whereHas('PengajuanStatus',function($pengajuanStatus){
                return $pengajuanStatus->where('status','Approve');
            })->doesntHave('SaldoKeluar')->get()
        ]);
    }

    public function create(){
        return view('pengajuan.input',[
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
            'action' => 'Create'
        ]);
    }

    public function edit($id){
        return view('pengajuan.input',[
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
            'action' => 'Edit',
            'data' => Pengajuan::find($id)
        ]);
    }

    public function delete($id){
        return view('pengajuan.input',[
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
            'action' => 'Delete',
            'data' => Pengajuan::find($id)
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required',
            'kategori_pemasukan_id' => 'required',
            'tipe_pembayaran_id' => 'required',
            'kategori_pengeluaran_id' => 'required'
        ],[
            'tanggal.required' => 'Tanggal wajib di isi',
            'tanggal.date' => 'Format tanggal salah',
            'jumlah.required' => 'Jumlah wajib di isi',
            'jumlah.numeric' => 'Format jumlah harus angka',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'kategori_pemasukan_id.required' => 'Kategori pemasukan wajib di isi',
            'tipe_pembayaran_id.required' => 'Tipe pembayaran wajib di isi',
            'kategori_pengeluaran_id.required' => 'Kategori pengeluaran wajib di isi'
        ]);

        try {
            $data = new Pengajuan();
            $data->tanggal = date('Y-m-d',strtotime(trim($request->input('tanggal'))));
            $data->jumlah = trim($request->input('jumlah'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->kategori_pemasukan_id = trim($request->input('kategori_pemasukan_id'));
            $data->tipe_pembayaran_id = trim($request->input('tipe_pembayaran_id'));
            $data->keterangan = $request->has('keterangan') ? trim($request->input('keterangan')) : null;
            $data->kategori_pengeluaran_id = trim($request->input('kategori_pengeluaran_id'));
            $data->save();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required',
            'kategori_pemasukan_id' => 'required',
            'tipe_pembayaran_id' => 'required',
            'kategori_pengeluaran_id' => 'required'
        ],[
            'tanggal.required' => 'Tanggal wajib di isi',
            'tanggal.date' => 'Format tanggal salah',
            'jumlah.required' => 'Jumlah wajib di isi',
            'jumlah.numeric' => 'Format jumlah harus angka',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'kategori_pemasukan_id.required' => 'Kategori pemasukan wajib di isi',
            'tipe_pembayaran_id.required' => 'Tipe pembayaran wajib di isi',
            'kategori_pengeluaran_id.required' => 'Kategori pengeluaran wajib di isi'
        ]);

        try {
            $data = Pengajuan::find($id);
            $data->tanggal = date('Y-m-d',strtotime(trim($request->input('tanggal'))));
            $data->jumlah = trim($request->input('jumlah'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->kategori_pemasukan_id = trim($request->input('kategori_pemasukan_id'));
            $data->tipe_pembayaran_id = trim($request->input('tipe_pembayaran_id'));
            $data->keterangan = $request->has('keterangan') ? trim($request->input('keterangan')) : null;
            $data->kategori_pengeluaran_id = trim($request->input('kategori_pengeluaran_id'));
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function destroy($id){
        try {
            $data = Pengajuan::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menghapus data')->withInput();
        }
    }

    public function proses($id){
        $data = Pengajuan::find($id);
        return view('pengajuan.saldokeluar.input',[
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
            'action' => 'Create',
            'data' => $data
        ]);
    }

    public function prosesPost(Request $request,$id){
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required',
            'kategori_pemasukan_id' => 'required',
            'tipe_pembayaran_id' => 'required',
            'kategori_pengeluaran_id' => 'required'
        ],[
            'tanggal.required' => 'Tanggal wajib di isi',
            'tanggal.date' => 'Format tanggal salah',
            'jumlah.required' => 'Jumlah wajib di isi',
            'jumlah.numeric' => 'Format jumlah harus angka',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'kategori_pemasukan_id.required' => 'Kategori pemasukan wajib di isi',
            'tipe_pembayaran_id.required' => 'Tipe pembayaran wajib di isi',
            'kategori_pengeluaran_id.required' => 'Kategori pengeluaran wajib di isi'
        ]);

        try {
            Pengajuan::find($id)->SaldoKeluar()->create([
                'tanggal' => date('Y-m-d',strtotime(trim($request->input('tanggal')))),
                'jumlah' => trim($request->input('jumlah')),
                'deskripsi' => trim($request->input('deskripsi')),
                'kategori_pemasukan_id' => trim($request->input('kategori_pemasukan_id')),
                'tipe_pembayaran_id' => trim($request->input('tipe_pembayaran_id')),
                'keterangan' => $request->has('keterangan') ? trim($request->input('keterangan')) : null,
                'kategori_pengeluaran_id' => trim($request->input('kategori_pengeluaran_id'))
            ]);
            
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data '.$th)->withInput();
        }
    }
}
