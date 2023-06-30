<?php

namespace App\Models;

use App\Models\Examen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'year',
    // ];
    protected $guarded = [];


    /**
     * % Get All Examens of An Academic Year
     */
    public function examens()
    {
        return $this->hasMany(Examen::class);
    }

    /**
     * % Get all The PVs of an Academic Year
     */
    public function pvs()
    {
        return $this->hasMany(pv::class);
    }
}