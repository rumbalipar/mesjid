<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKasKeluar extends Model
{
    use HasFactory;

    protected $table = 'arus_kas_keluars';

    protected $primaryKey = 'id';

    protected $fillable = ['arus_kas_id','seq','deskripsi'];

    protected $visible = ['id','arus_kas_id','seq','deskripsi'];

    public function ArusKas(){
        return $this->belongsTo(ArusKas::class,'arus_kas_id','id');
    }

    public function KategoriPengeluarans(){
        return $this->belongsToMany(KategoriPengeluaran::class,'arus_kas_keluar_kategori_pengeluaran','arus_kas_keluar_id','kategori_pengeluaran_id')->withTimestamps();
    }
}
