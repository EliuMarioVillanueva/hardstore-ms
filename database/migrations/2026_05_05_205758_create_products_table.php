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
    Schema::create('products', function (Blueprint $table) {
        $table->id(); // PK [cite: 36, 38]
        $table->string('sku')->unique(); // El SKU debe ser único [cite: 37, 39]
        $table->string('name'); // Cambiado de 'nombre' a 'name'
        $table->string('tipo'); // Placa, CPU, RAM, etc. [cite: 40, 43]
        $table->decimal('precio_venta', 12, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
