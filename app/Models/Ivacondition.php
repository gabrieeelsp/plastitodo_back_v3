<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ivacondition extends Model
{
    use HasFactory;

    public function modelofacts()
    {
        return $this->belongsToMany(Modelofact::class);
    }

    public function accept_modelofact ($id) {
        foreach ( $this->modelofacts as $item) {
            if ( $item->id == $id ) {
                return true;
            }
        }
        return false;
    }

    public $timestamps = false;
}
