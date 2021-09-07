<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nama_bank');
            $table->string('nama_deposito');
            $table->integer('jumlah');
            $table->double('bunga');
            $table->integer('rekening_id');
            $table->string('jatuh_tempo');
            $table->integer('gain_or_loss')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('biaya_lain')->nullable();
            $table->integer('financial_plan_id');
            $table->integer('rekening_jual_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('depositos');
    }
}
