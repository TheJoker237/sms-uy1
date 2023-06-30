<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * ! Get All of The Session's Examens
     */
    public function examen(){
        return $this->morphOne(Examen::class,'examable');
    }
}
