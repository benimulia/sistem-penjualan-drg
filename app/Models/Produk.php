<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
            'id_cabang',
            'nama_produk',
            'stok',
            'satuan',
            'harga_cash',
            'harga_bon',
            'harga_beli',
            'diskon',
            'created_by',
            'updated_by',
    ];

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'id_cabang', 'id_cabang');
    }

}
