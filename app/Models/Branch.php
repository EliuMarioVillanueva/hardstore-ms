<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'es_principal'];

    // Relación: Una sucursal tiene muchos usuarios
    public function users() {
        return $this->hasMany(User::class, 'sucursal_id');
    }

    // Relación: Una sucursal tiene muchos registros de stock
    public function stocks() {
        return $this->hasMany(Stock::class, 'sucursal_id');
    }
    
}

