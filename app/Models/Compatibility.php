<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    protected $fillable = ['producto_id', 'tipo_socket', 'tipo_ram', 'generacion_cpu'];

    public function product() {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
