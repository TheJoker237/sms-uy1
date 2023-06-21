<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Course;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examen extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation Many to One between Examens and Academic Year
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Relation Many to Many between Examens and Filieres
    public function filieres()
    {
        $this->belongsToMany(Filiere::class);
    }

    // Relation Many to Many between Examens and Facultes
    public function facultes()
    {
        return $this->belongsToMany(Faculte::class);
    }

    // Relation Many to Many between Examens and Courses
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    // Relation One to Many between Examen and Notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}