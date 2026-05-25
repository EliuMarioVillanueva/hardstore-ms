<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    
    protected $fillable = [
        'venta_id',
        'numero_factura',
        'ruta_pdf',
        'total',
        'estado'
    ];
    
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    
    // Generar número de factura automático
    public static function generarNumero()
    {
        $year = now()->year;
        $month = now()->month;
        
        $ultimaFactura = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimaFactura) {
            $ultimoNumero = intval(substr($ultimaFactura->numero_factura, -4));
            $nuevoNumero = str_pad($ultimoNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nuevoNumero = '0001';
        }
        
        return "F{$year}{$month}-{$nuevoNumero}";
    }
}