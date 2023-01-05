<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->integer('id_cabang');
            $table->string('nama_produk')->unique();
            $table->float('stok', 5, 2);
            $table->string('satuan');
            $table->integer('harga_cash');
            $table->integer('harga_bon');
            $table->integer('harga_beli');
            $table->integer('diskon')->default(0);
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
        Schema::dropIfExists('produk');
    }
}
