<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('kode');
            $table->integer('lot');
            $table->integer('harga_beli');
            $table->integer('harga_jual')->nullable();
            $table->integer('total');
            $table->integer('biaya_lain')->nullable();
            $table->integer('rekening_id');
            $table->integer('rekening_jual_id')->nullable();
            $table->integer('financial_plan_id');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
