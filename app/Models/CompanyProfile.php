<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profiles';

    protected $primaryKey = 'id';

    protected $fillable = ['nama','website','alamat','logo','pemilik','tanggal_berdiri','telepon','email'];

    protected $visible = ['id','nama','website','alamat','logo','pemilik','tanggal_berdiri','telepon','email'];
}
