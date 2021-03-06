<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengeluarans';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','deskripsi','approval'];

    protected $visible = ['id','kode','deskripsi','approval'];

    public function SaldoKeluars(){
        return $this->hasMany(SaldoKeluar::class,'kategori_pengeluaran_id','id');
    }

    public function Pengajuans(){
        return $this->hasMany(Pengajuan::class,'kategori_pengeluaran_id','id');
    }

    public function ArusKasKeluars(){
        return $this->belongsToMany(ArusKasKeluar::class,'arus_kas_keluar_kategori_pengeluaran','kategori_pengeluaran_id','arus_kas_keluar_id')->withTimestamps();
    }
}
