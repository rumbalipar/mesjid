<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Models\Pengajuan;
use App\Models\PengajuanStatus;
use App\Models\TipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApprovalController extends Controller
{
    private $perPage = 20;

    public function index(Request $request){
        $data = Pengajuan::whereDoesntHave('PengajuanStatus');
        $history = Pengajuan::whereHas('PengajuanStatus');

        $tangga_dari = $request->has('tanggal_dari') && trim($request->input('tanggal_dari')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_dari')))) : "";
        $tangga_sampai = $request->has('tanggal_sampai') && trim($request->input('tanggal_sampai')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_sampai')))) : "";

        if($tangga_dari != "" && $tangga_sampai != ""){
            $history = $history->whereDate('tanggal','>=',$tangga_dari)->whereDate('tanggal','<=',$tangga_sampai);
        }elseif($tangga_dari != "" && $tangga_sampai == ""){
            $history = $history->whereDate('tanggal','>=',$tangga_dari);
        }elseif($tangga_dari == "" && $tangga_sampai != ""){
            $history = $history->whereDate('tanggal','<=',$tangga_sampai);
        }


        $history = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $history->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $history;
        $history = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != '' ? $history->where('kategori_pemasukan_id',trim($request->input('kategori_pemasukan_id'))) : $history;
        $history = $request->has('tipe_pembayaran_id') && trim($request->input('tipe_pembayaran_id')) != '' ? $history->where('tipe_pembayaran_id',trim($request->input('tipe_pembayaran_id'))) : $history;
        $history = $request->has('kategori_pengeluaran_id') && trim($request->input('kategori_pengeluaran_id')) != '' ? $history->where('kategori_pengeluaran_id',trim($request->input('kategori_pengeluaran_id'))) : $history;

        return view('approval.index',[
            'data' => $data->orderBy('tanggal','asc')->orderBy('id','asc')->get(),
            'history' => $history->orderBy('tanggal','desc')->orderBy('id','desc')->paginate($this->perPage)->withQueryString(),
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
        ]);
    }

    public function history(Request $request){
        $data = Pengajuan::whereHas('PengajuanStatus');

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

        return view('approval.history',[
            'data' => $data->orderBy('tanggal','desc')->orderBy('id','desc')->paginate($this->perPage)->withQueryString(),
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategoripengeluaran' => KategoriPengeluaran::orderBy('deskripsi')->get(),
        ]);
    }

    public function input($id){
        return view('approval.input',[
            'data' => Pengajuan::find($id),
            'status' => PengajuanStatus::$status,
            'action' => 'Submit'
        ]);
    }

    public function post(Request $request,$id){
        $request->validate([
            'status' => 'required'
        ]);

        try {
            Pengajuan::find($id)->PengajuanStatus()->create([
                'status' => $request->input('status'),
                'tanggal' => date('Y-m-d'),
                'jam' => date('H:i:s'),
                'keterangan' => $request->input('keterangan'),
                'user_id' => session()->get('sesiuserid')
            ]);
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Berhasil');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal')->withInput();
        }
    }

    public function reset($id){
        return view('approval.input',[
            'data' => Pengajuan::find($id),
            'status' => PengajuanStatus::$status,
            'action' => 'Reset'
        ]);
    }

    public function postReset(Request $request,$id){
        try {
            Pengajuan::find($id)->PengajuanStatus()->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Berhasil');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal')->withInput();
        }
    }
}
