<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $primaryKey = 'id_cabang';

    protected $fillable = [
        'nama_cabang',
        'kategori',
        'alamat_cabang',
        'tgl_buka',
    ];
}
