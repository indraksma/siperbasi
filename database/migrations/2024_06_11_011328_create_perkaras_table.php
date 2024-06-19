<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerkarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkaras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('tanggal_terima');
            $table->date('tanggal_putusan')->nullable();
            $table->text('barang_bukti');
            $table->string('photo')->nullable();
            $table->string('no_perkara');
            $table->text('nama_tersangka');
            $table->integer('status');
            $table->string('amar_putusan')->nullable();
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
        Schema::dropIfExists('perkaras');
    }
}
