<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupUser;
use App\Models\Module;
use Illuminate\Support\Facades\Redirect;

class GroupUserController extends Controller
{
    public $perPage = 20;

    public function index(Request $request){
        $data = new GroupUser();

        $data = $request->has('kode') && trim($request->input('kode')) != '' ? $data->where('kode','like','%'.trim($request->input('kode')).'%') : $data;
        $data = $request->has('deskripsi') && trim($request->input('deskripsi')) != '' ? $data->where('deskripsi','like','%'.trim($request->input('deskripsi')).'%') : $data;

        return view('groupuser.index',[
            'data' => $data->paginate($this->perPage)->withQueryString()
        ]);
    }

    public function create(){
        return view('groupuser.input',[
            'action' => 'Create',
            'akses' => GroupUser::$akses,
            'module' => Module::orderBy('group_module_id')->get()
        ]);
    }

    public function edit($id){
        return view('groupuser.input',[
            'data' => GroupUser::find($id),
            'action' => 'Edit',
            'akses' => GroupUser::$akses,
            'module' => Module::orderBy('group_module_id')->get()
        ]);
    }

    public function delete($id){
        return view('groupuser.input',[
            'data' => GroupUser::find($id),
            'action' => 'Delete',
            'akses' => GroupUser::$akses,
            'module' => Module::orderBy('group_module_id')->get()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'kode' => 'required|unique:group_users,kode',
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = new GroupUser();
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->save();
            if($request->has('module') && count($request->input('module')) > 0){
                foreach($request->input('module') as $modules):
                    $pivot = [];
                    foreach(GroupUser::$akses as $akses):
                        $pivot[$akses] = $request->has($akses) && isset($request->input($akses)[$modules]) && $request->input($akses)[$modules] == 'Y' ? 'Y' : 'N';
                    endforeach;
                    $data->Module()->attach($modules,$pivot);
                endforeach;
            }
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'kode' => 'required|unique:group_users,kode,'.$id,
            'deskripsi' => 'required'
        ],[
            'kode.required' => 'Kode wajib di isi',
            'kode.unique' => 'Kode sudah di gunakan',
            'deskripsi.required' => 'Deskripsi wajib di isi'
        ]);

        try {
            $data = GroupUser::find($id);
            $data->kode = trim($request->input('kode'));
            $data->deskripsi = trim($request->input('deskripsi'));
            $data->update();
            GroupUser::find($id)->Module()->detach();
            if($request->has('module') && count($request->input('module')) > 0){
                foreach($request->input('module') as $modules):
                    $pivot = [];
                    foreach(GroupUser::$akses as $akses):
                        $pivot[$akses] = $request->has($akses) && isset($request->input($akses)[$modules]) && $request->input($akses)[$modules] == 'Y' ? 'Y' : 'N';
                    endforeach;
                    GroupUser::find($id)->Module()->attach($modules,$pivot);
                endforeach;
            }
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data ')->withInput();
        }
    }

    public function destroy($id){
        try {
            $data = GroupUser::find($id);
            $data->delete();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di hapus');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal hapus data')->withInput();
        }
    }
}
