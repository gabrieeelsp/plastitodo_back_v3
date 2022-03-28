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
}
