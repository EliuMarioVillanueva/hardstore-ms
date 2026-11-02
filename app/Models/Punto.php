<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punto extends Model
{
    protected $table = 'puntos';
    
    protected $fillable = ['user_id', 'cantidad', 'total_acumulado'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Agregar puntos
    public function agregarPuntos($monto)
    {
        $puntosGanados = floor($monto / 10);
        $this->cantidad += $puntosGanados;
        $this->total_acumulado += $puntosGanados;
        $this->save();
        
        return $puntosGanados;
    }
    
    // Verificar si puede tirar el gacha
    public function puedeTirarGacha()
    {
        return $this->cantidad >= 100;
    }
}