<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'tipo', 'precio_venta'];

    public function stocks() {
        // Relación con la tabla stocks usando la columna producto_id
        return $this->hasMany(Stock::class, 'producto_id');
    }

    public function compatibility() {
        return $this->hasOne(Compatibility::class, 'producto_id');
    }
}