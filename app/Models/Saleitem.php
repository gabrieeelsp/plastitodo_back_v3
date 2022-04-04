<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleitem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function saleproduct()
    {
        return $this->belongsTo(Saleproduct::class);
    }
    
    public function iva ()
    {
        return $this->belongsTo(Iva::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function devolutionitems()
    {
        return $this->hasMany(Devolutionitem::class);
    }

    public function get_cant_disponible_devolucion () {
        $cant = $this->cantidad;
        foreach ( $this->devolutionitems as $devitem ) {
            $cant = $cant - $devitem->cantidad;
        }
        return $cant;
    }

    public function get_cant_total_disponible_devolucion () {
        $cant = $this->cantidad_total;
        foreach ( $this->devolutionitems as $devitem ) {
            $cant = $cant - $devitem->cantidad_total;
        }
        return $cant;
    }

    // Importe neto gravado
    public function getImpNeto()
    {
        if ( $this->saleproduct->stockproduct->is_stock_unitario_kilo ) {
            $impNeto = round($this->precio * $this->cantidad_total, 4, PHP_ROUND_HALF_UP);
        }else {
            $impNeto = round($this->precio * $this->cantidad, 4, PHP_ROUND_HALF_UP);
        }
        

        return round($impNeto / (1 + round($this->iva->valor / 100, 4, PHP_ROUND_HALF_UP)), 2, PHP_ROUND_HALF_UP);
    }
    

    public function getImpIvaEsp ( ) {
        $imp = round($this->precio * $this->cantidad, 4, PHP_ROUND_HALF_UP);
        return round($imp - $this->getImpNeto(), 2, PHP_ROUND_HALF_UP);
    }
}
