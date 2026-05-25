<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['usuario_id', 'total', 'fecha', 'sucursal_id'];

    public function user() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // 👇 AGREGAR ESTE MÉTODO
    public function sucursal() {
        return $this->belongsTo(Branch::class, 'sucursal_id');
    }
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}