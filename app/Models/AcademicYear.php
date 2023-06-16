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

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }
}