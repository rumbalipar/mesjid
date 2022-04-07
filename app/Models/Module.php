<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $primaryKey = 'id';

    protected $fillable = ['deskripsi','route','icon','group_module_id'];

    protected $visible = ['id','deskripsi','route','icon','group_module_id'];

    public function GroupModule(){
        return $this->belongsTo(GroupModule::class,'group_module_id','id');
    }

    public function GroupUser(){
        return $this->belongsToMany(GroupUser::class,'group_user_module','module_id','group_user_id')->withPivot('buat','ubah','hapus')->withTimestamps();
    }
}
