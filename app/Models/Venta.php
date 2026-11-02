<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $fillable = [
        'usuario_id',
        'total',
        'fecha',
        'sucursal_id',
        'estado',
        'metodo_pago',
        'confirmado_at',
        'confirmado_por',
    ];

    protected $casts = [
        'confirmado_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal() {
        return $this->belongsTo(Branch::class, 'sucursal_id');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class);
    }

    public function confirmadoPor()
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }
}