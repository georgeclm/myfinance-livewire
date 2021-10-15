<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeToMutualFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mutual_funds', function (Blueprint $table) {
            $table->decimal('unit')->change();
            $table->decimal('harga_beli')->change();
            $table->decimal('harga_jual')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mutual_funds', function (Blueprint $table) {
            //
        });
    }
}
