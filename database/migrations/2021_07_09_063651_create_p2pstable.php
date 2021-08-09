<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2PSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2ps', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nama_p2p');
            $table->integer('jumlah');
            $table->integer('bunga');
            $table->integer('rekening_id');
            $table->string('jatuh_tempo');
            $table->integer('harga_jual')->nullable();
            $table->integer('biaya_lain')->nullable();
            $table->integer('financial_plan_id');
            $table->integer('rekening_jual_id')->nullable();
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
        Schema::dropIfExists('p2_p_s');
    }
}
