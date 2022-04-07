<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoMasuk extends Model
{
    use HasFactory;

    protected $table = 'saldo_masuks';

    protected $primaryKey = 'id';

    protected $fillable = ['tanggal','jumlah','deskripsi','pemberi','penerima','kategori_pemasukan_id','tipe_pembayaran_id','keterangan','telp'];

    protected $visible = ['id','tanggal','jumlah','deskripsi','pemberi','penerima','kategori_pemasukan_id','tipe_pembayaran_id','keterangan','telp'];

    public function KategoriPemasukan(){
        return $this->belongsTo(KategoriPemasukan::class,'kategori_pemasukan_id','id');
    }

    public function TipePembayaran(){
        return $this->belongsTo(TipePembayaran::class,'tipe_pembayaran_id','id');
    }
}
