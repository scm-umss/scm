<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaHistorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_historials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('evento',['Creado', 'Modificado', 'Confirmado','Atendido','Cancelado']);
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('cita_historials');
    }
}
