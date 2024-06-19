<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangBuktisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_buktis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penyitaan_id');
            $table->bigInteger('putusan_id')->nullable();
            $table->string('nama_barang');
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status');
            $table->enum('isPublic', [0, 1])->nullable();
            $table->enum('isSold', [0, 1])->nullable();
            $table->text('ket_status')->nullable();
            $table->string('foto_status')->nullable();
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
        Schema::dropIfExists('barang_buktis');
    }
}
