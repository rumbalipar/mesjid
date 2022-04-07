<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanStatus extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_statuses';

    protected $primaryKey = 'id';

    protected $fillable = ['pengajuan_id','status','tanggal','jam','keterangan','user_id'];

    protected $visible = ['id','pengajuan_id','status','tanggal','jam','keterangan','user_id'];

    public static $status = [
        'Approve',
        'Not Approve'
    ];

    public function Pengajuan(){
        return $this->belongsTo(Pengajuan::class,'pengajuan_id','id');
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
