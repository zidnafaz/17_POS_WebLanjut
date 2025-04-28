<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_suplier';

    protected $primaryKey = 'id_suplier';

    protected $fillable = [
        'kode_suplier',
        'nama_suplier',
        'no_telepon',
        'alamat',
    ];
}
