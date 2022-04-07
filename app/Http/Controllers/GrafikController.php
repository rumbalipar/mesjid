<?php

namespace App\Http\Controllers;

use App\Helpers\Month;
use App\Models\CompanyProfile;
use App\Models\KategoriPemasukan;
use App\Models\SaldoKeluar;
use App\Models\SaldoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function month(Request $request){
        $dari = $request->has('dari') && trim($request->input('dari')) != '' ? trim($request->input('dari')) : date('m-Y',strtotime('-3 month',strtotime(date('Y-m-d'))));
        $sampai = $request->has('sampai') && trim($request->input('sampai')) != '' ? trim($request->input('sampai')) : date('m-Y',strtotime(date('Y-m-d')));
        $kategori_pemasukan_id = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != "" ? trim($request->input('kategori_pemasukan_id')) : '';
        
        $tanggal_dari = date('Y-m-d',strtotime('01-'.$dari));
        $tanggal_sampai = date('Y-m-d',strtotime('-1 day',strtotime(date('Y-m-d',strtotime('+1 month',strtotime('01-'.$sampai))))));

        $saldoMasuk = SaldoMasuk::select(DB::raw('MONTH(tanggal) bulan'), DB::raw('YEAR(tanggal) tahun'));
        $saldoKeluar = SaldoKeluar::select(DB::raw('MONTH(tanggal) bulan'), DB::raw('YEAR(tanggal) tahun'));

        $saldoMasuk = $saldoMasuk->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai);
        $saldoKeluar = $saldoKeluar->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai);

        if($kategori_pemasukan_id != ""){
            $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
        }

        $data = $saldoMasuk->union($saldoKeluar)->get();
        $grafik = [];
        foreach($data as $datas):
            array_push(
                $grafik,[
                    "label" => Month::getName($datas->bulan).' '.$datas->tahun,
                    "saldomasuk" => $this->saldoMasukMonth($datas->bulan,$datas->tahun,$kategori_pemasukan_id),
                    "saldokeluar" => $this->saldoKeluarMonth($datas->bulan,$datas->tahun,$kategori_pemasukan_id)
                ]
                );
        endforeach;
        return view('main.grafikmonth',[
            'dari' => $dari,
            'sampai' => $sampai,
            'grafik' => json_encode($grafik),
            'periode' => date('F Y',strtotime('01-'.$dari)).' s/d '.date('F Y',strtotime('01-'.$sampai)),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'applicationcompany' => CompanyProfile::first(),
        ]);
    }

    public function year(Request $request){
        $dari = $request->has('dari') && trim($request->input('dari')) != '' ? trim($request->input('dari')) : date('Y',strtotime('-3 year',strtotime(date('Y-m-d'))));
        $sampai = $request->has('sampai') && trim($request->input('sampai')) != '' ? trim($request->input('sampai')) : date('Y',strtotime(date('Y-m-d')));
        $kategori_pemasukan_id = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != "" ? trim($request->input('kategori_pemasukan_id')) : '';
        $grafik = [];

        $saldoMasuk = SaldoMasuk::select(DB::raw('YEAR(tanggal) tahun'));
        $saldoKeluar = SaldoKeluar::select(DB::raw('YEAR(tanggal) tahun'));

        $saldoMasuk = $saldoMasuk->whereYear('tanggal','>=',$dari)->whereYear('tanggal','<=',$sampai);
        $saldoKeluar = $saldoKeluar->whereYear('tanggal','>=',$dari)->whereDate('tanggal','<=',$sampai);

        if($kategori_pemasukan_id != ""){
            $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
        }

        $data = $saldoMasuk->union($saldoKeluar)->get();
        $grafik = [];
        foreach($data as $datas):
            array_push(
                $grafik,[
                    "label" => $datas->tahun,
                    "saldomasuk" => $this->saldoMasukYear($datas->tahun,$kategori_pemasukan_id),
                    "saldokeluar" => $this->saldoKeluarYear($datas->tahun,$kategori_pemasukan_id)
                ]
                );
        endforeach;

        return view('main.grafikyear',[
            'dari' => $dari,
            'sampai' => $sampai,
            'periode' => $dari.' s/d '.$sampai,
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'grafik' => json_encode($grafik),
            'applicationcompany' => CompanyProfile::first(),
        ]);
    }

    public function saldoMasukYear($year = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($year) != ""){
            $saldoMasuk = new SaldoMasuk();
            if($kategori_pemasukan_id != ""){
                $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoMasuk->whereYear('tanggal',$year)->sum('jumlah');
        }
        return $saldo;
    }

    public function saldoMasukMonth($month = "",$year = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($month) != "" && trim($year) != ""){
            $saldoMasuk = new SaldoMasuk();
            if($kategori_pemasukan_id != ""){
                $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoMasuk->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah');
        }
        return $saldo;
    }

    public function saldoKeluarYear($year = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($year) != ""){
            $saldoKeluar = new SaldoKeluar();
            if($kategori_pemasukan_id != ""){
                $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoKeluar->whereYear('tanggal',$year)->sum('jumlah');
        }
        return $saldo;
    }

    public function saldoKeluarMonth($month = "",$year = "", $kategori_pemasukan_id = ""){
        $saldo = 0;
        if(trim($month) != "" && trim($year) != ""){
            $saldoKeluar = new SaldoKeluar();
            if($kategori_pemasukan_id != ""){
                $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
            }
            return $saldoKeluar->whereMonth('tanggal',$month)->whereYear('tanggal',$year)->sum('jumlah');
        }
        return $saldo;
    }
}
