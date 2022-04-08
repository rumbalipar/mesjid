<?php

namespace App\Http\Controllers;

use App\Helpers\Terbilang;
use App\Models\CompanyProfile;
use App\Models\KategoriPemasukan;
use App\Models\SaldoMasuk;
use App\Models\TipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SaldoMasukController extends Controller
{
    private $perPage = 20;

    public function index(Request $request){
        $data = new SaldoMasuk();

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
        $data = $request->has('pemberi') && trim($request->input('pemberi')) != '' ? $data->where('pemberi','like','%'.trim($request->input('pemberi')).'%') : $data;
        $data = $request->has('penerima') && trim($request->input('penerima')) != '' ? $data->where('penerima','like','%'.trim($request->input('penerima')).'%') : $data;
        $data = $request->has('kategori_pemasukan_id') && trim($request->input('kategori_pemasukan_id')) != '' ? $data->where('kategori_pemasukan_id',trim($request->input('kategori_pemasukan_id'))) : $data;
        $data = $request->has('tipe_pembayaran_id') && trim($request->input('tipe_pembayaran_id')) != '' ? $data->where('tipe_pembayaran_id',trim($request->input('tipe_pembayaran_id'))) : $data;

        return view('saldomasuk.index',[
            'data' => $data->orderBy('tanggal','desc')->orderBy('id','desc')->paginate($this->perPage)->withQueryString(),
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get()
        ]);
    }

    public function create(){
        return view('saldomasuk.input',[
            'action' => 'Create',
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get()
        ]);
    }

    public function edit($id){
        return view('saldomasuk.input',[
            'action' => 'Edit',
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'data' => SaldoMasuk::find($id)
        ]);
    }

    public function delete($id){
        return view('saldomasuk.input',[
            'action' => 'Delete',
            'tipepembayaran' => TipePembayaran::orderBy('deskripsi')->get(),
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'data' => SaldoMasuk::find($id)
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'required',
            'pemberi' => 'required',
            'penerima' => 'required',
            'kategori_pemasukan_id' => 'required',
            'tipe_pembayaran_id' => 'required'
        ],[
            'tanggal.required' => 'Tanggal wajib di isi',
            'tanggal.date' => 'Format tanggal salah',
            'jumlah.required' => 'Jumlah wajib di isi',
            'jumlah.numeric' => 'Format jumlah harus angka',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'pemberi.required' => 'Pemberi wajib di isi',
            'penerima.required' => 'Penerima wajib di isi',
            'kategori_pemasukan_id.required' => 'Kategori pemasukan wajib di isi',
            'tipe_pembayaran_id.required' => 'Tipe pembayaran wajib di isi'
        ]);

        try {
            $data = new SaldoMasuk();
            $data->tanggal = date('Y-m-d',strtotime(trim($request->input('tanggal'))));
            $data->jumlah = trim($request->input('jumlah'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->penerima = trim($request->input('penerima'));
            $data->pemberi = trim($request->input('pemberi'));
            $data->kategori_pemasukan_id = trim($request->input('kategori_pemasukan_id'));
            $data->tipe_pembayaran_id = trim($request->input('tipe_pembayaran_id'));
            $data->keterangan = $request->has('keterangan') ? trim($request->input('keterangan')) : null;
            $data->telp = $request->has('telp') ? trim($request->input('telp')) : null;
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
            'pemberi' => 'required',
            'penerima' => 'required',
            'kategori_pemasukan_id' => 'required',
            'tipe_pembayaran_id' => 'required'
        ],[
            'tanggal.required' => 'Tanggal wajib di isi',
            'tanggal.date' => 'Format tanggal salah',
            'jumlah.required' => 'Jumlah wajib di isi',
            'jumlah.numeric' => 'Format jumlah harus angka',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'pemberi.required' => 'Pemberi wajib di isi',
            'penerima.required' => 'Penerima wajib di isi',
            'kategori_pemasukan_id.required' => 'Kategori pemasukan wajib di isi',
            'tipe_pembayaran_id.required' => 'Tipe pembayaran wajib di isi'
        ]);

        try {
            $data = SaldoMasuk::find($id);
            $data->tanggal = date('Y-m-d',strtotime(trim($request->input('tanggal'))));
            $data->jumlah = trim($request->input('jumlah'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->penerima = trim($request->input('penerima'));
            $data->pemberi = trim($request->input('pemberi'));
            $data->kategori_pemasukan_id = trim($request->input('kategori_pemasukan_id'));
            $data->tipe_pembayaran_id = trim($request->input('tipe_pembayaran_id'));
            $data->keterangan = $request->has('keterangan') ? trim($request->input('keterangan')) : null;
            $data->telp = $request->has('telp') ? trim($request->input('telp')) : null;
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }
    
    public function destroy($id){
        try {
            SaldoMasuk::find($id)->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }

    public function kwitansi($id){
        date_default_timezone_set("Asia/Bangkok");
        header('Content-Type: application/pdf');
        $profile = CompanyProfile::first();
        $logoUrl = isset($profile['logo']) ? url('/').'/assets/images/'.$profile['logo'] : '';
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
            'default_font_size' => 9,
            'default_font' => 'Arial',
            'mode' => 'utf-8',
        ]);

        $mpdf->SetHTMLHeader($header);

        $data = SaldoMasuk::find($id);

        $html = \view('saldomasuk.kwitansi',[
            "data" => $data,
            'terbilang' => isset($data['jumlah']) && $data['jumlah'] > 0 ? Terbilang::indonesia($data['jumlah']) : ''
        ]);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output("kwitansi",'I');
    }
}
