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

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }


    public function filieres()
    {
        $this->belongsToMany(Filiere::class);
    }

    public function facultes()
    {
        return $this->belongsToMany(Faculte::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}