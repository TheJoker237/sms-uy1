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

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
