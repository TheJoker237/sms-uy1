<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use App\Models\Student;
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

    // Relation One to Many Filieres and Courses
    public function courses(){
        return $this->hasMany(Course::class);
    }

    // Relation Many to one Filieres and Fculte
    public function faculte(){
        return $this->belongsTo(Faculte::class);
    }

    // Relation Many to Many Filieres and Examens
    public function examens()
    {
        return $this->belongsToMany(Examen::class);
    }

    // Relation One to Many Filiere and Students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
