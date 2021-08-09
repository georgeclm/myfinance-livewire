<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        DB::table('categories')->insert(
            array(
                ['nama' => 'Sedekah atau Donasi'],
                ['nama' => 'Cicilan'],
                ['nama' => 'Makanan'],
                ['nama' => 'Pengeluaran Pribadi'],
                ['nama' => 'Kendaraan'],
                ['nama' => 'Nongky'],
                ['nama' => 'Admin'],
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
        Schema::dropIfExists('categories');
    }
}
