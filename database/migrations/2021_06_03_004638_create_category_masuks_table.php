<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        DB::table('category_masuks')->insert(
            array(
                ['nama' => 'Gaji'],
                ['nama' => 'Bonus dan Tunjangan'],
                ['nama' => 'Pendapatan Pasif'],
                ['nama' => 'Bisnis'],
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
        Schema::dropIfExists('category_masuks');
    }
}
