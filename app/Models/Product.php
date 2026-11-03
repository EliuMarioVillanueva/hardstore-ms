<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hamzi\NativeRag\Contracts\EmbeddableContract;
use Hamzi\NativeRag\Traits\Embeddable;

class Product extends Model implements EmbeddableContract
{
    use Embeddable;

    protected $fillable = ['sku', 'name', 'tipo', 'precio_venta'];

    public function stocks() {
        return $this->hasMany(Stock::class, 'producto_id');
    }

    public function compatibility() {
        return $this->hasOne(Compatibility::class, 'producto_id');
    }

    // Este método es obligatorio para que el paquete sepa qué texto indexar
    public function toEmbeddableString(): string
    {
        return "Producto: {$this->name}\nSKU: {$this->sku}\nTipo: {$this->tipo}\nPrecio: \${$this->precio_venta}";
    }
}