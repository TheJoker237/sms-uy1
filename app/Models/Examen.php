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

    /**
     * % Get Academic Year of An Examen
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * % Get Courses that Belongs to The Examen
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    /**
     * % Get All The Notes of And Examen
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // 

    /**
     * ! Get The parent Examable Model ( Controle or Session)
     */
    public function examable()
    {
        return $this->morphTo();
    }

}