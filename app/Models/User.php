<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = ['username','password','nama','email','group_user_id','foto'];

    protected $visible = ['id','username','password','nama','email','group_user_id','foto'];

    public function GroupUser(){
        return $this->belongsTo(GroupUser::class,'group_user_id','id');
    }

    public function PengajuanStatuses(){
        return $this->hasMany(PengajuanStatus::class,'user_id','id');
    }
}
