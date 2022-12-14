<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'foto_pelanggan',
        'foto_identitas',
        'alamat_pelanggan',
        'created_by',
        'updated_by',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class,'id_pelanggan','id_pelanggan');
    }

}
