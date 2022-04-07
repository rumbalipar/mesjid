<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    protected $table = 'group_users';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','deskripsi'];

    protected $visible = ['id','kode','deskripsi'];

    public static $akses = ['buat','ubah','hapus'];

    public function User(){
        return $this->hasMany(User::class,'group_user_id','id');
    }

    public function Module(){
        return $this->belongsToMany(Module::class,'group_user_module','group_user_id','module_id')->withPivot('buat','ubah','hapus')->withTimestamps();
    }
}
