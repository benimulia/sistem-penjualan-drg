<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapBayarBonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_bayar_bon', function (Blueprint $table) {
            $table->bigIncrements('id_bayar_bon');
            $table->integer('id_bon');
            $table->date('tgl_bayar');
            $table->integer('jumlah_cicil');
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
        Schema::dropIfExists('rekap_bayar_bon');
    }
}
