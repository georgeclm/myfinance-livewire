<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLengthToP2psTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p2ps', function (Blueprint $table) {
            $table->bigInteger('jumlah')->change();
            $table->bigInteger('harga_jual')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p2ps', function (Blueprint $table) {
            //
        });
    }
}
