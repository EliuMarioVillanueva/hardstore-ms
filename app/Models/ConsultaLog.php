<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaLog extends Model
{
    protected $table = 'consulta_logs';
    protected $fillable = ['user_id', 'pregunta', 'respuesta'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}