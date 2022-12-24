<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBon extends Model
{
    use HasFactory;
    protected $table = 'rekap_bon';
    protected $primaryKey = 'id_bon';

    protected $fillable = [
            'id_cabang',
            'id_pelanggan',
            'id_penjualan',
            'tgl_bon',
            'total',
            'jumlah_terbayar',
            'status',
            'keterangan',
            'created_by',
            'updated_by',
    ];

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function cabang()
    {
        return $this->hasOne(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function rekapbayarbon()
    {
        return $this->hasMany(RekapBayarBon::class, 'id_bon', 'id_bon');
    }
}
