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

    /**
     * % Get The Filieres of Faculte
     */
    public function filieres(){
        return $this->hasMany(Filiere::class);
    }

}