<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModule extends Model
{
    use HasFactory;

    protected $table = 'group_modules';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','deskripsi'];

    protected $visible = ['id','kode','deskripsi'];

    public function Module(){
        return $this->hasMany(Module::class,'group_module_id','id');
    }
}
