<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBayarBon extends Model
{
    use HasFactory;
    protected $table = 'rekap_bayar_bon';
    protected $primaryKey = 'id_bayar_bon';

    protected $fillable = [
            'id_bon',
            'tgl_bayar',
            'jumlah_cicil',
            'keterangan',
            'created_by',
            'updated_by',
    ];

    public function rekapbon()
    {
        return $this->hasOne(RekapBon::class, 'id_bon', 'id_bon');
    }
}
