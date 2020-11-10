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


            $table->foreignId('paciente_id')->constrained('users');
            $table->foreignId('medico_id')->constrained('users');
            $table->foreignId('especialidad_id')->constrained();
            $table->foreignId('sucursal_id')->constrained('sucursal');
            $table->date('fecha_programada');
            $table->time('hora_programada');
            $table->enum('estado', ['Reservada', 'Confirmada', 'Atendida', 'Cancelada'])->default('Reservada');

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
