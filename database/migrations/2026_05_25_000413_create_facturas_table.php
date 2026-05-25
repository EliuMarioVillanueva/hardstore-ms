<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas');
            $table->string('numero_factura')->unique(); // Ej: F001-2026-0001
            $table->string('ruta_pdf')->nullable(); // Ruta donde se guardó el PDF
            $table->decimal('total', 12, 2);
            $table->string('estado')->default('emitida'); // emitida, pagada, anulada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};