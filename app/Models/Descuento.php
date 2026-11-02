<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';
    
    protected $fillable = ['user_id', 'tipo', 'valor', 'usado', 'usado_at'];
    
    protected $casts = [
        'usado_at' => 'datetime',
        'usado' => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getDescripcionAttribute()
    {
        if ($this->tipo === 'envio_gratis') {
            return 'Envío gratis';
        }
        return $this->valor . '% de descuento';
    }
}