<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
            'id_user',
            'tgl_pembelian',
            'supplier',
            'total_pembelian',
            'created_by',
            'updated_by',
    ];

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class, 'id_pembelian_detail', 'id_pembelian_detail');
    }

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'id_cabang', 'id_cabang');
    }
    
}
