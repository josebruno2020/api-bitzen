<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmesCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmes_categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filme_id')->unsigned();
            $table->integer('categoria_id')->unsigned();


            $table->foreign('filme_id')
                ->references('id')
                ->on('filmes');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias');
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
        Schema::dropIfExists('filmes_categorias');
    }
}
