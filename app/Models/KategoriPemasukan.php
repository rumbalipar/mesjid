<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPemasukan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pemasukans';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','deskripsi'];

    protected $visible = ['id','kode','deskripsi'];

    public function SaldoMasuks(){
        return $this->hasMany(SaldoMasuk::class,'kategori_pemasukan_id','id');
    }

    public function SaldoKeluars(){
        return $this->hasMany(SaldoKeluar::class,'kategori_pemasukan_id','id');
    }

    public function Pengajuans(){
        return $this->hasMany(Pengajuan::class,'kategori_pemasukan_id','id');
    }
}
