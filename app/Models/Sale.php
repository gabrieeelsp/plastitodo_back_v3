<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function saleItems()
    {
        return $this->hasMany(Saleitem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function refonds()
    {
        return $this->hasMany(Refond::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function devolutions()
    {
        return $this->hasMany(Devolution::class);
    }

    public function creditnotes()
    {
        return $this->hasMany(Creditnote::class);
    }
    public function debitnotes()
    {
        return $this->hasMany(Debitnote::class);
    }

    public function comprobante()
    {
        return $this->morphOne(Comprobante::class, 'comprobanteable');
    }

    // Importe neto no gravado
    public function ImpTotConc() 
    {
        return 0;
    }

    // Importe neto gravado
    public function getImpNeto()
    {
        $impNeto = 0;
        foreach ( $this->saleItems as $saleItem ) {
            $impNeto = round($impNeto + $saleItem->getImpNeto(), 2, PHP_ROUND_HALF_UP);
        } 
        return $impNeto;
    }

    // Importe total de IVA
    public function getImpIVA() 
    {
        return round($this->total - $this->getImpNeto(), 2, PHP_ROUND_HALF_UP);
    }

    // Importe total de IVA 
    public function getImpIvaEsp($iva_id) 
    {
        $impIvaEsp = 0;
        foreach ( $this->saleItems as $saleItem ) {
            if ( $saleItem->iva->id == $iva_id ){
                $impIvaEsp = round($impIvaEsp + $saleItem->getImpIvaEsp(), 2, PHP_ROUND_HALF_UP);
            }
            
        } 
        return $impIvaEsp;
    }

    public function getBaseImpIvaEsp($iva_id) 
    {
        $baseImpIvaEsp = 0;
        foreach ( $this->saleItems as $saleItem ) {
            if ( $saleItem->iva->id == $iva_id ){
                $baseImpIvaEsp = round($baseImpIvaEsp + $saleItem->getImpNeto(), 2, PHP_ROUND_HALF_UP);
            }
            
        } 
        return $baseImpIvaEsp;
    }
}
