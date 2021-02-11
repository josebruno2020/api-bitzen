<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmesAtoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmes_atores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filme_id')->unsigned();
            $table->integer('ator_id')->unsigned();


            $table->foreign('filme_id')
                ->references('id')
                ->on('filmes');
            $table->foreign('ator_id')
                ->references('id')
                ->on('atores');
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
        Schema::dropIfExists('filmes_atores');
    }
}
