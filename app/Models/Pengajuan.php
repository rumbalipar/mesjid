<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';

    protected $primaryKey = 'id';

    protected $fillable = ['tanggal','jumlah','deskripsi','tipe_pembayaran_id','kategori_pengeluaran_id','kategori_pemasukan_id','keterangan'];

    protected $visible = ['id','tanggal','jumlah','deskripsi','tipe_pembayaran_id','kategori_pengeluaran_id','kategori_pemasukan_id','keterangan'];

    public function TipePembayaran(){
        return $this->belongsTo(TipePembayaran::class,'tipe_pembayaran_id','id');
    }
    
    public function KategoriPengeluaran(){
        return $this->belongsTo(KategoriPengeluaran::class,'kategori_pengeluaran_id','id');
    }

    public function KategoriPemasukan(){
        return $this->belongsTo(KategoriPemasukan::class,'kategori_pemasukan_id','id');
    }

    public function PengajuanStatus(){
        return $this->hasOne(PengajuanStatus::class,'pengajuan_id','id');
    }

    public function SaldoKeluar(){
        return $this->hasOne(SaldoKeluar::class,'pengajuan_id','id');
    }
}
