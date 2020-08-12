<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();


            $table->dateTime('fecha_hora');
            $table->foreignId('paciente_id')->constrained('users');
            $table->foreignId('medico_id')->constrained('users');
            $table->foreignId('especialidad_id')->constrained();
            $table->enum('estado', ['Reservada', 'Confirmada', 'Atendida', 'Cancelada']);
            $table->integer('numero_ficha');

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
        Schema::dropIfExists('citas');
    }
}
