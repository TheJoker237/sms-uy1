<?php

namespace App\Models;

use App\Models\User;
use App\Models\Doyen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'teacher_id',
    //     'full_name',
    //     'gender',
    //     'date_of_birth',
    //     'mobile',
    //     'joining_date',
    //     'qualification',
    //     'experience',
    //     'username',
    //     'address',
    //     'city',
    //     'state',
    //     'zip_code',
    //     'country',
    // ];

    protected $guarded = [];
    
    /**
     * ! Get the parent Teacherable model (doyen or Not)
     */
    public function teacherable()
    {
        return $this->morphTo();
    }

    /**
     * % Get all the Courses of a Teacher
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * ! Get the Teacher's user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
