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
        Schema::create('compatibilities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('products')->cascadeOnDelete();   
        $table->string('tipo_socket')->nullable(); // Ej: AM4, LGA1700
        $table->string('tipo_ram')->nullable(); // Ej: DDR4, DDR5
        $table->timestamps();
        $table->string('generacion_cpu')->nullable(); // Ej: 12va Gen, Zen 4 [cite: 83, 85]
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilities');
    }
};
