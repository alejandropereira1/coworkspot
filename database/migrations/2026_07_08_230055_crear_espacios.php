<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_espacio_id')->constrained('tipos_espacio')->onDelete('cascade');
            $table->string('nombre');
            $table->integer('capacidad');
            $table->decimal('precio_por_hora', 8, 2);
            $table->integer('piso')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espacios');
    }
};
