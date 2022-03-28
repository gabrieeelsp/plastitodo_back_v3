<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolutionitem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function saleitem()
    {
        return $this->belongsTo(Saleitem::class);
    }

    public function devolution()
    {
        return $this->belongsTo(Devolution::class);
    }
}
