<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    public function comprobanteable()
    {
        return $this->morphTo();
    }

    public function modelofact()
    {
        return $this->belongsTo(Modelofact::class);
    }
}
