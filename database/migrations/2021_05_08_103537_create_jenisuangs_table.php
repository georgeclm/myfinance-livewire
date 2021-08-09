<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJenisuangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenisuangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        DB::table('jenisuangs')->insert(
            array(
                ['nama' => 'Uang Masuk'],
                ['nama' => 'Uang Keluar'],
                ['nama' => 'Transfer'],
                ['nama' => 'Bayar Utang'],
                ['nama' => 'Teman Bayar Utang'],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenisuangs');
    }
}
