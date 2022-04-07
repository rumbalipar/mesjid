<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;
use App\Models\SaldoKeluar;
use App\Models\SaldoMasuk;
use Illuminate\Http\Request;

class TransaksiSaldoController extends Controller
{
    private $perPage = 20;
    public function saldo($tanggal = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($tanggal) != "" && date('Y-m-d',strtotime(trim($tanggal)))){
            $saldoMasuk = new SaldoMasuk();
            $saldoKeluar = new SaldoKeluar();
            if($kategori_pemasukan_id != ""){
                $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
                $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            $saldoMasuk = $saldoMasuk->whereDate('tanggal','<=',$tanggal)->sum('jumlah');
            $saldoKeluar = $saldoKeluar->whereDate('tanggal','<=',$tanggal)->sum('jumlah');
            return $saldoMasuk - $saldoKeluar;
        }
        return $saldo;
    }

    public function saldoMasuk($tanggal = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($tanggal) != "" && date('Y-m-d',strtotime(trim($tanggal)))){
            $saldoMasuk = new SaldoMasuk();
            if($kategori_pemasukan_id != ""){
                $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoMasuk->whereDate('tanggal',$tanggal)->sum('jumlah');
        }
        return $saldo;
    }

    public function saldoKeluar($tanggal = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($tanggal) != "" && date('Y-m-d',strtotime(trim($tanggal)))){
            $saldoKeluar = new SaldoKeluar();
            if($kategori_pemasukan_id != ""){
                $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoKeluar->whereDate('tanggal',$tanggal)->sum('jumlah');
        }
        return $saldo;
    }

    public function index(Request $request){
        $tanggal_dari = $request->has('tanggal_dari') && trim($request->input('tanggal_dari')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_dari')))) : '';
        $tanggal_sampai = $request->has('tanggal_sampai') && trim($request->input('tanggal_sampai')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_sampai')))) : '';
        $kategori_pemasukan_id = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != "" ? trim($request->input('kategori_pemasukan_id')) : '';
        $saldoMasuk = SaldoMasuk::select('tanggal');
        $saldoKeluar = SaldoKeluar::select('tanggal');
        if($tanggal_dari != "" && $tanggal_sampai != ""){
            $saldoMasuk = $saldoMasuk->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai);
            $saldoKeluar = $saldoKeluar->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai);
        }elseif($tanggal_dari != "" && $tanggal_sampai == ""){
            $saldoMasuk = $saldoMasuk->whereDate('tanggal','>=',$tanggal_dari);
            $saldoKeluar = $saldoKeluar->whereDate('tanggal','>=',$tanggal_dari);
        }elseif($tanggal_dari == "" && $tanggal_sampai != ""){
            $saldoMasuk = $saldoMasuk->whereDate('tanggal','<=',$tanggal_sampai);
            $saldoKeluar = $saldoKeluar->whereDate('tanggal','<=',$tanggal_sampai);
        }

        if($kategori_pemasukan_id != ""){
            $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
        }

        $data = $saldoMasuk->union($saldoKeluar)->orderBy('tanggal','desc')->paginate($this->perPage)->withQueryString();

        return view('transaksisaldo.index',[
            'data' => $data,
            'self' => $this,
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategori_pemasukan_id' => $kategori_pemasukan_id
        ]);
    }

    public function viewSaldoMasuk(Request $request,$tanggal){
        $data = [];
        $kategori_pemasukan_id = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != "" ? trim($request->input('kategori_pemasukan_id')) : '';
        if(trim($tanggal) != "" && date('Y-m-d',strtotime(trim($tanggal)))){
            $data = SaldoMasuk::whereDate('tanggal',$tanggal);
            if($kategori_pemasukan_id != ""){
                $data = $data->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            $data = $data->get();
        }
        return view('transaksisaldo.saldomasuk',[
            'data' => $data
        ]);
    }

    public function viewSaldoKeluar(Request $request,$tanggal){
        $data = [];
        $kategori_pemasukan_id = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != "" ? trim($request->input('kategori_pemasukan_id')) : '';
        if(trim($tanggal) != "" && date('Y-m-d',strtotime(trim($tanggal)))){
            $data = SaldoKeluar::whereDate('tanggal',$tanggal);
            if($kategori_pemasukan_id != ""){
                $data = $data->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            $data = $data->get();
        }
        return view('transaksisaldo.saldokeluar',[
            'data' => $data
        ]);
    }
}
