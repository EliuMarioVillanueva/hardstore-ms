<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['sucursal_id', 'producto_id', 'cantidad']; //

    public function branch() {
        return $this->belongsTo(Branch::class, 'sucursal_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}

