<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class CompanyProfileController extends Controller
{
    public function index(){
        return view('companyprofile.index',[
            'data' => CompanyProfile::first()
        ]);
    }

    public function post(Request $request){
        $request->validate([
            'nama' => 'required'
        ],[
            'nama.required' => 'Nama perusahaan wajib di isi'
        ]);

        $data = CompanyProfile::first();

        $logo = isset($data['logo']) && $data['logo'] != null && trim($data['logo']) != '' ? trim($data['logo']) : '';

        if($request->hasFile('logo')){
            try {
                $logo = date('YmdHis').$request->file('logo')->getClientOriginalName();
                $request->file('logo')->move('./assets/images/',$logo);
                if(isset($data['logo']) && $data['logo'] != null && trim($data['logo']) != '' &&  file_exists('./assets/images/'.trim($data['logo']))){
                    try {
                        File::delete('./assets/images/'.trim($data['logo']));
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            } catch (\Throwable $th) {
                return Redirect::back()->with('error','Gagal upload icon')->withInput();
            }
        }

        try {
            CompanyProfile::first()->update([
                'nama' => trim($request->input('nama')),
                'website' => $request->has('website') ? trim($request->input('website')) : '',
                'alamat' => $request->has('alamat') ? trim($request->input('alamat')) : '',
                'pemilik' => $request->has('pemilik') ? trim($request->input('pemilik')) : '',
                'tanggal_berdiri' => $request->has('tanggal_berdiri') && trim($request->input('tanggal_berdiri')) != '' ? date('Y-m-d',strtotime(trim($request->input('tanggal_berdiri')))) : '',
                'telepon' => $request->has('telepon') ? trim($request->input('telepon')) : '',
                'email' => $request->has('email') ? trim($request->input('email')) : '',
                'logo' => $logo
            ]);
            return Redirect::back()->with('success','Berhasil')->withInput();
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal')->withInput();
        }
    }
}
