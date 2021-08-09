<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInvestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        DB::table('investations')->insert(
            array(
                ['nama' => 'Deposito'],
                ['nama' => 'Obligasi'],
                ['nama' => 'Reksadana'],
                ['nama' => 'Saham'],
                ['nama' => 'P2P'],
                ['nama' => 'Mata Uang Asing'],
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
        Schema::dropIfExists('investations');
    }
}
