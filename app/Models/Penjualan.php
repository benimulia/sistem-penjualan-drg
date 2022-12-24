<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
            'id_cabang',
            'id_pelanggan',
            'tgl_penjualan',
            'jenis_transaksi',
            'status_transaksi',
            'total_penjualan',
            'jumlah_bayar',
            'keterangan',
            'created_by',
            'updated_by',


    ];

    public function penjualandetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan_detail', 'id_penjualan_detail');
    }

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}

