<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePutusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('putusans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_putusan');
            $table->string('no_putusan');
            $table->string('pengadilan');
            $table->string('penuntut');
            $table->string('terpidana');
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
        Schema::dropIfExists('putusans');
    }
}
