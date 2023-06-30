<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controle extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * ! Get The Controle's Examen
     */
    public function examen(){
        return $this->morphOne(Examen::class,'examable');
    }
}
