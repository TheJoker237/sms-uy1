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

    // Relation One to Many Student and Notes 
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Relation Many to One Student and Filiere
    public function filiere()
    {
        $this->belongsTo(Filiere::class);
    }
    
    /**
     * Get the Student's User.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
