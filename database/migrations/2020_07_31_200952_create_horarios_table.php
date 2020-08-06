<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('dia');
            $table->boolean('tm_activo');
            $table->time('tm_hora_inicio');
            $table->time('tm_hora_fin');
            $table->foreignId('tm_sucursal')->constrained('sucursal')->cascadeOnDelete();
            $table->foreignId('tm_especialidad')->constrained('especialidads')->cascadeOnDelete();
            //$table->integer('tm_sucursal');
            $table->boolean('tt_activo');
            $table->time('tt_hora_inicio');
            $table->time('tt_hora_fin');
            $table->foreignId('tt_sucursal')->constrained('sucursal')->cascadeOnDelete();
            $table->foreignId('tt_especialidad')->constrained('especialidads')->cascadeOnDelete();
            //$table->integer('tt_sucursal');

            $table->foreignId('user_id')->constrained();
            //$table->integer('tm_sucursal')->unsigned();
            //$table->foreign('tm_sucursal')->references('id')->on('sucursal');
            //$table->integer('tt_sucursal')->unsigned();
            //$table->foreign('tt_sucursal')->references('id')->on('sucursal');

            // $table->foreignId('tt_sucursal')->constrained();

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
        Schema::dropIfExists('horarios');
    }
}
