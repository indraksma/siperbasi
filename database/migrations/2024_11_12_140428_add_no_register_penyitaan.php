<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoRegisterPenyitaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyitaans', function (Blueprint $table) {
            $table->string('no_register')->nullable()->after('tersangka');
            $table->string('tanggal_register')->nullable()->after('no_register');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyitaans', function (Blueprint $table) {
            $table->dropColumn('no_register');
            $table->dropColumn('tanggal_register');
        });
    }
}
