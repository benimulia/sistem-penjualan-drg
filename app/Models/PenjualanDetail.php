<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';

    protected $fillable = [
            'id_penjualan',
            'id_produk',
            'satuan',
            'harga',
            'qty',
            'subtotal',
            'created_by',
            'updated_by',
    ];

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
