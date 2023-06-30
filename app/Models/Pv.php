<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pv extends Model
{
    use HasFactory;

    /**
     * % Get The Course of a PV
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * % Get The Academic Year of a PV
     */
    public function academic_year()
    {
        return $this->belongsTo(academicYear::class);
    }
}
