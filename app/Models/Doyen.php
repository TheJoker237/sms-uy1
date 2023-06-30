<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doyen extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * ! Get the Doyen's Teacher
     */
    public function teacher(){
        return $this->morphOne(Teacher::class, 'teacherable');
    }
}
