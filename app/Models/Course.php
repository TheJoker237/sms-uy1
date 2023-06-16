<?php

namespace App\Models;

use App\Models\Examen;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'code',
    //     'title',
    // ];
    protected $guarded = [];

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    public function examens(){
        return $this->belongsToMany(Examen::class);
    }

    
}
