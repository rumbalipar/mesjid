<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKas extends Model
{
    use HasFactory;

    protected $table = 'arus_kas';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','seq','deskripsi'];

    protected $visible = ['id','seq','kode','deskripsi'];

    public function ArusKasMasuks(){
        return $this->hasMany(ArusKasMasuk::class,'arus_kas_id','id');
    }

    public function ArusKasKeluars(){
        return $this->hasMany(ArusKasKeluar::class,'arus_kas_id','id');
    }
}
