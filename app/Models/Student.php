<?php

namespace App\Models;

use App\Models\Note;
use App\Models\User;
use App\Models\Filiere;
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

    /**
     * % Get All Notes of an Student
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * % Get The Filiere of an Student
     */
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    
    /**
     * ! Get the Student's User.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
