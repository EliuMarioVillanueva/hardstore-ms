<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('estado')->default('pendiente')->after('total');
            $table->string('metodo_pago')->default('transferencia')->after('estado');
            $table->timestamp('confirmado_at')->nullable()->after('metodo_pago');
            $table->foreignId('confirmado_por')->nullable()->after('confirmado_at')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['confirmado_por']);
            $table->dropColumn(['estado', 'metodo_pago', 'confirmado_at', 'confirmado_por']);
        });
    }
};