<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GroupUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public $perPage = 20;

    public function index(Request $request){
        $data = new User();

        $data = $request->has('username') && trim($request->input('username')) != '' ? $data->where('username','like','%'.trim($request->input('username')).'%') : $data;
        $data = $request->has('nama') && trim($request->input('nama')) != '' ? $data->where('nama','like','%'.trim($request->input('nama')).'%') : $data;
        $data = $request->has('email') && trim($request->input('email')) != '' ? $data->where('email','like','%'.trim($request->input('email')).'%') : $data;

        return view('user.index',[
            'data' => $data->paginate($this->perPage)->withQueryString(),
            'groupuser' => GroupUser::orderBy('kode')->get()
        ]);
    }

    public function create(){
        return view('user.input',[
            'groupuser' => GroupUser::orderBy('kode')->get(),
            'action' => 'Create'
        ]);
    }

    public function edit($id){
        return view('user.input',[
            'data' => User::find($id),
            'groupuser' => GroupUser::orderBy('kode')->get(),
            'action' => 'Edit'
        ]);
    }

    public function delete($id){
        return view('user.input',[
            'data' => User::find($id),
            'groupuser' => GroupUser::orderBy('kode')->get(),
            'action' => 'Delete'
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'nama' => 'required',
            'password' => 'required',
            'group_user_id' => 'required'
        ],[
            'username.required' => 'Username wajib di isi',
            'username.unique' => 'Username sudah di gunakan',
            'email.required' => 'Email wajib di isi',
            'email.unique' => 'Email sudah di gunakan',
            'email.email' => 'Format email salah',
            'nama.required' => 'Nama wajib di isi',
            'password.required' => 'Password wajib di isi',
            'group_user_id.required' => 'Group wajib di isi'
        ]);

        $foto = null;
        if($request->hasFile('foto')){
            try {
                $foto = date('YmdHis').$request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./assets/images/user/',$foto);
            } catch (\Throwable $th) {
                Redirect::back()->with('error','Gagal upload foto')->withInput();
            }
        }

        try {
            $data = new User();
            $data->username = trim($request->input('username'));
            $data->nama = trim($request->input('nama'));
            $data->password = Hash::make(trim($request->input('password')));
            $data->group_user_id = trim($request->input('group_user_id'));
            $data->email = trim($request->input('email'));
            $data->foto = $foto;
            $data->save();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di tambahkan');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal menyimpan data')->withInput();
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'nama' => 'required',
            //'password' => 'required',
            'group_user_id' => 'required'
        ],[
            'username.required' => 'Username wajib di isi',
            'username.unique' => 'Username sudah di gunakan',
            'email.required' => 'Email wajib di isi',
            'email.unique' => 'Email sudah di gunakan',
            'email.email' => 'Format email salah',
            'nama.required' => 'Nama wajib di isi',
            //'password.required' => 'Password wajib di isi',
            'group_user_id.required' => 'Group wajib di isi'
        ]);

        $data = User::find($id);

        $foto = isset($data['foto']) ? $data['foto'] : null;

        if($request->hasFile('foto')){
            try {
                $foto = date('YmdHis').$request->file('foto')->getClientOriginalName();
                $request->file('foto')->move('./assets/images/user/',$foto);
                if(file_exists('./assets/images/user/'.$data['foto'])){
                    try {
                        File::delete('./assets/images/user/'.$data['foto']);
                    } catch (\Throwable $th) {
                        
                    }
                }
            } catch (\Throwable $th) {
                Redirect::back()->with('error','Gagal upload foto')->withInput();
            }
        }

        try {
            $data->username = trim($request->input('username'));
            $data->nama = trim($request->input('nama'));
            $data->password = $request->has('password') && trim($request->input('password')) != '' ? Hash::make(trim($request->input('password'))) : $data['password'];
            $data->group_user_id = trim($request->input('group_user_id'));
            $data->email = trim($request->input('email'));
            $data->foto = $foto;
            $data->update();
            return "<script>parent.$('#modal-action').modal('hide');parent.alertWithRefresh('Data berhasil di ubah');</script>";
        } catch (\Throwable $th) {
            return Redirect::back()->with('error','Gagal mengubah data')->withInput();
        }
    }

    public function destroy($id){
        $data = User::find($id);
        $foto = isset($data['foto']) && $data['foto'] != '' ? $data['foto'] : '';
        if($foto != '' && file_exists('./assets/images/user/'.$foto)){
            try {
                File::delete('./assets/images/user/'.$foto);
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
