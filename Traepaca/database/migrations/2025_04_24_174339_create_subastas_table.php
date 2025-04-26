<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubastasTable extends Migration
{
    public function up()
    {
        Schema::create('subastas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_inicial', 10, 2);
            $table->boolean('activa')->default(true);
            $table->dateTime('fecha_limite');
            $table->unsignedBigInteger('usuario_id'); // Creador de la subasta
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subastas');
    }
}

?>