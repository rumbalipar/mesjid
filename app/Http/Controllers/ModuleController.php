<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\GroupModule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ModuleController extends Controller
{
    public $perPage = 20;

    public function index(Request $request){
        $data = new Module();

        $data = $request->has('group_module_id') && trim($request->input('group_module_id')) != '' ? $data->where('group_module_id',trim($request->input('group_module_id'))) : $data;
        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;
        
        return view('module.index',[
            'data' => $data->paginate($this->perPage)->withQueryString(),
            'groupmodule' => GroupModule::orderBy('kode')->get()
        ]);
    }

    public function create(){
        return view('module.input',[
            'action' => 'Create',
            'groupmodule' => GroupModule::orderBy('kode')->get()
        ]);
    }

    public function edit($id){
        return view('module.input',[
            'data' => Module::find($id),
            'groupmodule' => GroupModule::orderBy('kode')->get(),
            'action' => 'Edit'
        ]);
    }

    public function delete($id){
        return view('module.input',[
            'data' => Module::find($id),
            'action' => 'Delete',
            'groupmodule' => GroupModule::orderBy('kode')->get(),
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'deskripsi' => 'required|unique:modules,deskripsi',
            'route' => 'required',
            'group_module_id' => 'required',
            'icon' => 'required'
        ],[
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'deskripsi.unique' => 'Deskripsi sudaj di gunakan',
            'route.required' => 'Route wajib di isi',
            'icon.required' => 'Icon wajib di isi',
            'group_module_id.required' => 'Group wajib di isi'
        ]);

        try {
            $icon = date('YmdHis').$request->file('icon')->getClientOriginalName();
            $request->file('icon')->move('./assets/images/module/',$icon);
        } catch (\Throwable $th) {
            Redirect::back()->with('error','Gagal upload icon')->withInput();
        }

        try {
            $data = new Module();
            $data->group_module_id = trim($request->input('group_module_id'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->route = trim($request->input('route'));
            $data->icon = $icon;
            $data->save();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data '.$th)->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'deskripsi' => 'required|unique:modules,deskripsi,'.$id,
            'route' => 'required',
            'group_module_id' => 'required',
        ],[
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'deskripsi.unique' => 'Deskripsi sudaj di gunakan',
            'route.required' => 'Route wajib di isi',
            'group_module_id.required' => 'Group wajib di isi'
        ]);

        $data = Module::find($id);

        $icon = $data['icon'];

        if($request->hasFile('icon')){
            try {
                $icon = date('YmdHis').$request->file('icon')->getClientOriginalName();
                $request->file('icon')->move('./assets/images/module/',$icon);
                if(file_exists('./assets/images/module/'.$data['icon'])){
                    try {
                        File::delete('./assets/images/module/'.$data['icon']);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            } catch (\Throwable $th) {
                return Redirect::back()->with('error','Gagal upload icon')->withInput();
            }
        }

        try {
            $data->group_module_id = trim($request->input('group_module_id'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->route = trim($request->input('route'));
            $data->icon = $icon;
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function destroy($id){
        $data = Module::find($id);
        $icon = isset($data['icon']) && $data['icon'] != '' ? $data['icon'] : '';
        if($icon != '' && file_exists('./assets/images/module/'.$icon)){
            try {
                File::delete('./assets/images/module/'.$icon);
            } catch (\Throwable $th) {
                Redirect::back()->with('error', 'Data gagal di hapus');
            } 
        }

        try {
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Data gagal di hapus');
        }
       
    }

}
