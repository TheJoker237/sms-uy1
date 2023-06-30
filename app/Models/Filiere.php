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

    /**
     * % Get The Courses of The Filieres 
     */
    public function courses(){
        return $this->hasMany(Course::class);
    }

    /**
     * % Get The Faculty that Own The Filiere
     */
    public function faculte(){
        return $this->belongsTo(Faculte::class);
    }

    /**
     * % Get All Students Of A Filiere
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
