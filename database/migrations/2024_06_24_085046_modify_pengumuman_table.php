<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->longText('deskripsi')->after('tanggal');
            $table->dropColumn('tanggal_lelang', 'harga_limit', 'uang_jaminan', 'nama_barang', 'keterangan', 'photo', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->date('tanggal_lelang');
            $table->integer('harga_limit');
            $table->integer('uang_jaminan');
            $table->text('nama_barang');
            $table->text('keterangan');
            $table->string('photo')->nullable();
            $table->integer('status');
        });
    }
}
