<?php

namespace App\Models;

use App\Models\Examen;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * % Get the Examen's Note
     */
    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    /**
     * % Get the Student's Note
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * % Get The Course's Note 
     */
    public function course(){
        return $this->belongsTo(Course::class);
    }
}
