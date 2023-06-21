<?php

namespace App\Models;

use App\Models\Examen;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculte extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    // ];
    protected $guarded = [];

    // Relation One to Many Faculte and Filieres
    public function filieres(){
        return $this->hasMany(Filiere::class);
    }

    // Relation Many to Many Faculte and Examens
    public function examens()
    {
        return $this->belongsToMany(Examen::class);
    }
}