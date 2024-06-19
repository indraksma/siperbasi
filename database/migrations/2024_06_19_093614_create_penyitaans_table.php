<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyitaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyitaans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penyitaan');
            $table->string('no_penyitaan');
            $table->string('pengadilan');
            $table->string('penyidik');
            $table->string('penuntut');
            $table->text('tersangka');
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
        Schema::dropIfExists('penyitaans');
    }
}
