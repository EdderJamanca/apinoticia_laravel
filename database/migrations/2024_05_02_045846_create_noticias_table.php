<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id("NoticiaId");
            $table->foreignId('CategoriaId')->constrained('categorias', 'idcategoria');
            $table->string("Titulo",255);
            $table->text("Resumen");
            $table->string("Img",200)->nullable();
            $table->text("Contenido");
            $table->integer("Calificacion");
            $table->string("Nom_Autor",200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
