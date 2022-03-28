<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleproduct extends Model
{
    use HasFactory;

    public function stockproduct()
    {
        return $this->belongsTo(Stockproduct::class);
    }
}
