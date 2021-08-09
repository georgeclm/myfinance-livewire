<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicilans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nama');
            $table->integer('jenisuang_id');
            $table->integer('tanggal');
            $table->integer('rekening_id');
            $table->integer('rekening_id2')->nullable();
            $table->integer('utang_id')->nullable();
            $table->integer('utangteman_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('category_masuk_id')->nullable();
            $table->integer('bulan');
            $table->integer('sekarang');
            $table->integer('jumlah');
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
        Schema::dropIfExists('cicilans');
    }
}
