<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';

    protected $fillable = [
            'id_pembelian',
            'id_produk',
            'qty',
            'harga',
            'subtotal',
            'created_by',
            'updated_by',
    ];

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id_pembelian', 'id_pembelian');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
