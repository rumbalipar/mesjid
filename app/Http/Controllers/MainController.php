<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\User;
use App\Models\KategoriPemasukan;
use App\Models\SaldoKeluar;
use App\Models\SaldoMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class MainController extends Controller
{
    public function index(Request $request){
        $tanggal_dari = $request->has('tanggal_dari') && trim($request->input('tanggal_dari')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_dari')))) : date('Y-m-d');
        $tanggal_sampai = $request->has('tanggal_sampai') && trim($request->input('tanggal_sampai')) != "" ? date('Y-m-d',strtotime(trim($request->input('tanggal_sampai')))) : date('Y-m-d');
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
        $data = $saldoMasuk->union($saldoKeluar)->orderBy('tanggal','desc')->get();
        return view('main.index',[
            'data' => $data,
            'applicationcompany' => CompanyProfile::first(),
            'self' => $this,
            'kategori' => $kategori_pemasukan_id != '' ? KategoriPemasukan::find($kategori_pemasukan_id)->deskripsi : '', 
            'kategoripemasukan' => KategoriPemasukan::orderBy('deskripsi')->get(),
            'kategori_pemasukan_id' => $kategori_pemasukan_id,
            'tanggal_dari' => $tanggal_dari,
            'tanggal_sampai' => $tanggal_sampai,
            'saldomasuk' => $this->saldoMasukPeriode($tanggal_dari,$tanggal_sampai,$kategori_pemasukan_id),
            'saldokeluar' => $this->saldoKeluarPeriode($tanggal_dari,$tanggal_sampai,$kategori_pemasukan_id),
            'saldoawal' => $this->saldo(date('Y-m-d',strtotime('-1 day',strtotime($tanggal_dari))),$kategori_pemasukan_id),
            'saldoakhir' => $this->saldo($tanggal_sampai,$kategori_pemasukan_id)
        ]);
    }

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

    public function saldoMasukPeriode($tanggal_dari,$tanggal_sampai,$kategori_pemasukan_id = ""){
        $saldoMasuk = new SaldoMasuk();
        if($kategori_pemasukan_id != ""){
            $saldoMasuk = $saldoMasuk->where('kategori_pemasukan_id',$kategori_pemasukan_id);
        }
        return $saldoMasuk->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai)->sum('jumlah');
    }

    public function saldoKeluarPeriode($tanggal_dari,$tanggal_sampai,$kategori_pemasukan_id = ""){
        $saldoKeluar = new SaldoKeluar();
        if($kategori_pemasukan_id != ""){
            $saldoKeluar = $saldoKeluar->where('kategori_pemasukan_id',$kategori_pemasukan_id);
        }
        return $saldoKeluar->whereDate('tanggal','>=',$tanggal_dari)->whereDate('tanggal','<=',$tanggal_sampai)->sum('jumlah');
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
    public function indexLogin(){
        return view('main.login',[
            'data' => CompanyProfile::first()
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username wajib di isi',
            'password.required' => 'Password wajib di isi'
        ]);

        $username = trim($request->input('username'));
        $password = trim($request->input('password'));        

        $data = User::where('username',$username)->first();

        if(!isset($data['username'])){
            return Redirect::back()->withInput()->with('error','Username tidak di temukan');
        }

        if(!Hash::check($password,$data['password'])){
            return back()->with('error','Password anda salah')->withInput();   
        }

        $request->session()->put('sesiuserid',$data['id']);
        
        return Redirect::route('home');
    }

    public function logout(){
        if(session()->has('sesiuserid')){
            session()->pull('sesiuserid');
        }
        return redirect()->route('index.login')->with('error','Logout successfull');
    }

    public function ubahPassword(){
        return view('main.ubahpassword');
    }

    public function changePassword(Request $request){
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required',
            'repassword' => 'required'
        ],[
            'oldpassword.required' => 'Current password wajib di isi',
            'password.required' => 'New Password wajib di isi',
            'repassword.required' => 'Retype Password wajib di isi'
        ]);

        if(trim($request->input('password')) != trim($request->input('repassword'))){
            return Redirect::back()->with('error','New Password dan Retype Password harus sama')->withInput();
        }

        $data = User::find(session()->get('sesiuserid'));
        if(!isset($data['password'])){
            return Redirect::back()->with('error','Data user tidak di temukan')->withInput();
        }

        if(!Hash::check(trim($request->input('oldpassword')),$data['password'])){
            return Redirect::back()->with('error','Current Password salah')->withInput();   
        }

        try {
            $data->password = Hash::make(trim($request->input('password')));
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal ubah password')->withInput();
        }
    }

    public static function aksesUser(Request $request = NULL){
        $data = array();

        if(!session()->has('sesiuserid')){
            return $data;
        }

        $akses = User::find(session()->get('sesiuserid'))->GroupUser->Module();
        

        $akses = collect($akses->get());
        
        $groupModule = new GroupModule();
        $groupModule = collect($groupModule->whereIn('id',$akses->pluck('group_module_id')->toArray())->orderBy('deskripsi')->get())->toArray();
        foreach($groupModule as $groupModules):
            $module = new Module();
            $module = $request != NULL && $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $module->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $module;
            $modules = $module->where('group_module_id',$groupModules['id'])->whereIn('id',$akses->pluck('id')->toArray())->get();
            $module = collect($modules)->toArray();
            foreach($modules as $param):
                $data[$groupModules['deskripsi']][] = [
                    "id" => $param['id'],
                    "deskripsi" => $param['deskripsi'],
                    "route" => $param['route'],
                    "icon" => $param['icon'],
                    "group_module_id" => $param['group_module_id'],
                ];
            endforeach;
            // if(is_array($module) && count($module) > 0){
            //     $data[$groupModules['deskripsi']] = $module;
            // }
        endforeach;
       
        return $data;
    }

    public function home(Request $request){
        return view('main.home',[
            "data" => self::aksesUser($request)
        ]);
    }
}
