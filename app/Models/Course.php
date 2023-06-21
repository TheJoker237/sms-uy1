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

    // Relation Many to One between Courses and Filiere
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    // Relation Many to Many between Courses and Examens
    public function examens(){
        return $this->belongsToMany(Examen::class);
    }

    // Relation Many to Many between Courses and Teachers
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);    
    }
    
}
