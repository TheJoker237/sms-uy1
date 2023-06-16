<?php

namespace App\Models;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'first_name',
    //     'last_name',
    //     'gender',
    //     'date_of_birth',
    //     'roll',
    //     'blood_group',
    //     'religion',
    //     'email',
    //     'class',
    //     'section',
    //     'admission_id',
    //     'phone_number',
    //     'upload',
    // ];
    protected $guarded = [];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
