<?php

namespace App\Http\Controllers;

use App\Helpers\Month;
use App\Models\ArusKas;
use App\Models\CompanyProfile;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Models\SaldoKeluar;
use App\Models\SaldoMasuk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function month(Request $request){
        $periode = $request->has('periode') && trim($request->input('periode')) ? trim($request->input('periode')) : date('m-Y');
        $month = date('m',strtotime("01-".$periode));
        $year = date('Y',strtotime('01-'.$periode));
        $tanggal_awal = date('Y-m-d',strtotime('-1 day',strtotime(date('Y-m-d',strtotime('01-'.$periode)))));
        $tanggal_akhir = date('Y-m-d',strtotime('-1 day',strtotime('+ 1 month',strtotime(date('Y-m-d',strtotime('01-'.$periode))))));
        $saldoAwal = $this->saldoMonth($tanggal_awal);
        $saldoAkhir = $this->saldoMonth($tanggal_akhir);
        return view('main.laporanmonth',[
            'kategoripemasukan' => KategoriPemasukan::get(),
            'kategoripengeluaran' => KategoriPengeluaran::get(),
            'month' => $month,
            'year' => $year,
            'bulan' => Month::getName($month),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'saldoawal' => $saldoAwal,
            'saldoakhir' => $saldoAkhir
        ]);
    }

    public function saldoMonth($tanggal = "", $kategori_pemasukan_id = ""){
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

    public function arusKas(){
        return view('main.aruskas',[
            'data' => ArusKas::orderBy('seq')->get(),
            'self' => $this,
            'applicationcompany' => CompanyProfile::first()
        ]);
    }

    public function arusKasPdf(){
        date_default_timezone_set("Asia/Bangkok");
        header('Content-Type: application/pdf');
        $profile = CompanyProfile::first();
        $logoUrl = isset($profile['logo']) && $profile['logo'] != '' ? url('/').'/assets/images/'.$profile['logo'] : url('/').'/assets/images/logo.png';
        $nama = isset($profile['nama']) ? trim($profile['nama']) : '';
        $alamat = isset($profile['alamat']) ? nl2br(trim($profile['alamat'])) : '';
        $telepon = isset($profile['telepon']) ? trim($profile['telepon']) : '';
        $email = isset($profile['email']) ? trim($profile['email']) : '';
        $website = isset($profile['website']) ? trim($profile['website']) : '';
        $header = '<table style="width:100%;">
                            <tr>
                                <td style="width:50%">
                                    <img src="'.$logoUrl.'" style="max-height:60px;" />
                                </td>
                                <td style="width:50%; text-align:right;">
                                    <span style="font-size:10px;font-weight:bold">'.$nama.'</span><br>
                                    <span style="font-size:10px">'.$alamat.'</span><br>
                                    <span style="font-size:10px">'.$telepon.'</span><br>
                                    <span style="font-size:10px">'.$email.'</span><br>
                                    <span style="font-size:10px">'.$website.'</span><br>
                                </td>
                            </tr>
                        </table>';
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path('tempdir'),
            'margin_top' => 32,
            'margin_bottom' => 30,
            'margin_header' => 10,
            'margin_footer' => 11,
            'format' => 'A4',
            'default_font' => 'Arial',
            'default_font_size' => 10,
            'default_font' => 'Arial',
            'mode' => 'utf-8',
        ]);

        $mpdf->SetHTMLHeader($header);
        $html = \view('main.aruskaspdf',[
            'data' => ArusKas::orderBy('seq')->get(),
            'self' => $this,
            'applicationcompany' => CompanyProfile::first()
        ]);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $fileName = "Laporan Arus Kas.pdf";
        $mpdf->Output($fileName,'I');
    }

    public function penerimaanArusKas($id,$periode){
        $month = date('m',strtotime("01-".$periode));
        $year = date('Y',strtotime('01-'.$periode));
        $data = SaldoMasuk::whereHas('KategoriPemasukan',function($kategoriPemasukan) use($id){
            return $kategoriPemasukan->whereHas('ArusKasMasuks',function($arusKasMasuk) use($id){
                return $arusKasMasuk->where('arus_kas_id',$id);
            });
        })->whereMonth('tanggal',$month)->whereYear('tanggal',$year);

        return $data;
    }

    public function pengeluaranArusKas($id,$periode){
        $month = date('m',strtotime("01-".$periode));
        $year = date('Y',strtotime('01-'.$periode));
        $data = SaldoKeluar::whereHas('KategoriPengeluaran',function($kategoriPengeluaran) use($id){
            return $kategoriPengeluaran->whereHas('ArusKasKeluars',function($arusKasKeluar) use($id){
                return $arusKasKeluar->where('arus_kas_id',$id);
            });
        })->whereMonth('tanggal',$month)->whereYear('tanggal',$year);

        return $data;
    }

    public function saldoMasukArusKas($id,$periode){
        $month = date('m',strtotime("01-".$periode));
        $year = date('Y',strtotime('01-'.$periode));
        $data = SaldoMasuk::whereHas('KategoriPemasukan',function($kategoriPemasukan) use($id){
            return $kategoriPemasukan->whereHas('ArusKasMasuks',function($arusKasMasuk) use($id){
                return $arusKasMasuk->where('arus_kas_masuks.id',$id);
            });
        })->whereMonth('tanggal',$month)->whereYear('tanggal',$year);

        return $data;
    }

    public function saldoKeluarArusKas($id,$periode){
        $month = date('m',strtotime("01-".$periode));
        $year = date('Y',strtotime('01-'.$periode));
        $data = SaldoKeluar::whereHas('KategoriPengeluaran',function($kategoriPengeluaran) use($id){
            return $kategoriPengeluaran->whereHas('ArusKasKeluars',function($arusKasKeluar) use($id){
                return $arusKasKeluar->where('arus_kas_keluars.id',$id);
            });
        })->whereMonth('tanggal',$month)->whereYear('tanggal',$year);

        return $data;
    }
}
