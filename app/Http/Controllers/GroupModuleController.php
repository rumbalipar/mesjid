<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupModule;
use Illuminate\Support\Facades\Redirect;

class GroupModuleController extends Controller
{
    public $perPage = 20;

    public function index(Request $request){
        $data = new GroupModule();

        $data = $request->has('kode') && trim($request->input('kode')) != '' ? $data->where('kode','like','%'.trim($request->input('kode')).'%') : $data;
        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;

        return view('groupmodule.index',[
            'data' => $data->paginate($this->perPage)->withQueryString()
        ]);
    }

    public function create(){
        return view('groupmodule.input',[
            'action' => 'Create'
        ]);
    }

    public function edit($id){
        return view('groupmodule.input',[
            'data' => GroupModule::find($id),
            'action' => 'Edit'
        ]);
    }

    public function delete($id){
        return view('groupmodule.input',[
            'data' => GroupModule::find($id),
            'action' => 'Delete'
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'kode' => 'required|unique:group_modules,kode',
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = new GroupModule();
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
            'kode' => 'required|unique:group_modules,kode,'.$id,
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = GroupModule::find($id);
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
            $data = GroupModule::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }
}
