<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKasMasuk extends Model
{
    use HasFactory;

    protected $table = 'arus_kas_masuks';

    protected $primaryKey = 'id';

    protected $fillable = ['arus_kas_id','seq','deskripsi'];

    protected $visible = ['id','arus_kas_id','seq','deskripsi'];

    public function ArusKas(){
        return $this->belongsTo(ArusKas::class,'arus_kas_id','id');
    }

    public function KategoriPemasukans(){
        return $this->belongsToMany(KategoriPemasukan::class,'arus_kas_masuk_kategori_pemasukan','arus_kas_masuk_id','kategori_pemasukan_id')->withTimestamps();
    }

}
