<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan');
            $table->integer('id_cabang');
            $table->integer('id_pelanggan')->nullable();
            $table->date('tgl_penjualan');
            $table->string('jenis_transaksi');
            $table->string('status_transaksi');
            $table->integer('total_penjualan');
            $table->integer('jumlah_bayar');
            $table->text('keterangan')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
