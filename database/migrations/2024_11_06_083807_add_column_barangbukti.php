<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBarangbukti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang_buktis', function (Blueprint $table) {
            $table->integer('ekonomis_tinggi')->nullable()->default(0)->after('foto_eksekusi');
            $table->string('kondisi')->nullable()->after('ekonomis_tinggi');
            $table->date('tanggal_register')->nullable()->after('kondisi');
            $table->string('no_register')->nullable()->after('tanggal_register');
            $table->string('satuan')->nullable()->after('no_register');
            $table->text('ket_sidang')->nullable()->after('satuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang_buktis', function (Blueprint $table) {
            $table->dropColumn('ekonomis_tinggi');
            $table->dropColumn('kondisi');
            $table->dropColumn('tanggal_register');
            $table->dropColumn('no_register');
            $table->dropColumn('satuan');
            $table->dropColumn('ket_sidang');
        });
    }
}
