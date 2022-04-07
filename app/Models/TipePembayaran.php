<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipePembayaran extends Model
{
    use HasFactory;

    protected $table = 'tipe_pembayarans';

    protected $primaryKey = 'id';

    protected $fillable = ['kode','deskripsi'];

    protected $visible = ['id','kode','deskripsi'];

    public function SaldoMasuks(){
        return $this->hasMany(SaldoMasuk::class,'tipe_pembayaran_id','id');
    }

    public function SaldoKeluars(){
        return $this->hasMany(SaldoKeluar::class,'tipe_pembayaran_id','id');
    }

    public function Pengajuans(){
        return $this->hasMany(Pengajuan::class,'tipe_pembayaran_id','id');
    }
}
