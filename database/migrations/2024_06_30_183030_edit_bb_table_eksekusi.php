<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBbTableEksekusi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang_buktis', function (Blueprint $table) {
            $table->date('tanggal_eksekusi')->nullable()->after('isPublic');
            $table->text('ket_eksekusi')->nullable()->after('tanggal_eksekusi');
            $table->string('foto_eksekusi')->nullable()->after('ket_eksekusi');
            $table->dropColumn('isSold', 'ket_status', 'foto_status');
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
            $table->dropColumn('tanggal_eksekusi', 'ket_eksekusi', 'foto_eksekusi');
            $table->enum('isSold', [0, 1])->nullable();
            $table->text('ket_status')->nullable();
            $table->string('foto_status')->nullable();
        });
    }
}
