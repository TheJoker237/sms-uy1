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

    /**
     * % Get The Filiere That own the Course
     */
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    /**
     * % Get Examens That Belongs to The Course 
     */
    public function examens(){
        return $this->belongsToMany(Examen::class)->withTimestamps();
    }
    
    /**
     * % Get The Notes of The Course
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * % Get Teachers of This Course
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);    
    }

    /**
     * % Get All The PVs of an Course
     */
    public function pvs()
    {
        return $this->hasMany(pv::class);
    }
    
}
