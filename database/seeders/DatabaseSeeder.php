<?php

namespace Database\Seeders;

use App\Models\GroupModule;
use App\Models\GroupUser;
use App\Models\Module;
use App\Models\TipePembayaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        GroupUser::create([
            'kode' => 'Administrator', //1
            'deskripsi' => 'Administrator'
        ]);

        User::create([
            'username' => 'soleh', //1
            'password' => Hash::make('07082017'),
            'nama' => 'soleh',
            'email' => 'soleh.rasta@gmail.com',
            'group_user_id' => 1,
            'foto' => 'soleh.jpg'
        ]);

        User::create([
            'username' => 'wildan', //1
            'password' => Hash::make('alikhlas'),
            'nama' => 'wildan',
            'email' => 'wadjohany@gmail.com',
            'group_user_id' => 1,
            'foto' => 'user.png'
        ]);

        GroupModule::create([
            'kode' => 'Setting', //1
            'deskripsi' => 'Setting'
        ]);

        Module::create([
            'deskripsi' => 'Module', //1
            'route' => 'module.index',
            'icon' => 'module.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'User', //2
            'route' => 'user.index',
            'icon' => 'user.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Group Module', //3
            'route' => 'groupmodule.index',
            'icon' => 'groupmodule.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Group User', //4
            'route' => 'groupuser.index',
            'icon' => 'groupuser.png',
            'group_module_id' => 1
        ]);
        
        Module::create([
            'deskripsi' => 'Kategori Pemasukan', //5
            'route' => 'kategoripemasukan.index',
            'icon' => '20220319032548kategoripemasukan.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Kategori Pengeluaran', //6
            'route' => 'kategoripengeluaran.index',
            'icon' => '20220319041310kategoripengeluaran.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Tipe Pembayaran', //7
            'route' => 'tipepembayaran.index',
            'icon' => '20220319043847tipepembayaran.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Saldo Masuk', //8
            'route' => 'saldomasuk.index',
            'icon' => '20220320030152saldomasu.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Saldo Keluar', //9
            'route' => 'saldokeluar.index',
            'icon' => '20220320115744saldokeluars.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Transaksi Saldo', //10
            'route' => 'transaksisaldo.index',
            'icon' => '20220323064747saldotransaksi.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Pengajuan', //11
            'route' => 'pengajuan.index',
            'icon' => '20220323064914pengajuan.jpg',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Approval', //12
            'route' => 'approval.index',
            'icon' => '20220324074443approval.png',
            'group_module_id' => 1
        ]);

        Module::create([
            'deskripsi' => 'Profile', //13
            'route' => 'companyprofile.index',
            'icon' => '20220403062218profile.png',
            'group_module_id' => 1
        ]);

        GroupUser::find(1)->Module()->attach(1,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(2,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(3,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(4,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(5,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(6,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(7,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(8,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(9,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(10,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(11,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(12,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
        GroupUser::find(1)->Module()->attach(13,['buat' => 'Y','ubah' => 'Y','hapus' => 'Y']);
    }
}
