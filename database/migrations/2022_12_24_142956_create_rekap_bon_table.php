<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapBonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_bon', function (Blueprint $table) {
            $table->bigIncrements('id_bon');
            $table->integer('id_cabang');
            $table->integer('id_pelanggan');
            $table->integer('id_penjualan')->nullable();
            $table->date('tgl_bon');
            $table->integer('total');
            $table->integer('jumlah_terbayar');
            $table->string('status');
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
        Schema::dropIfExists('rekap_bon');
    }
}
