<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeToMutualFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mutual_funds', function (Blueprint $table) {
            $table->decimal('unit', $precision = 65, $scale = 4)->change();
            $table->decimal('harga_beli', $precision = 65, $scale = 2)->change();
            $table->decimal('harga_jual', $precision = 65, $scale = 2)->change();
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
