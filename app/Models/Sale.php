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
}
