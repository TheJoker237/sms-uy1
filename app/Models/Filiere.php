<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'title',
    //     'faculte_id',
    // ];
    protected $guarded = [];

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function faculte(){
        return $this->belongsTo(Faculte::class);
    }

    public function examens()
    {
        return $this->belongsToMany(Examen::class);
    }
}
