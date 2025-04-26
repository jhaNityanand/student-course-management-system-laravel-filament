<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'qualification',
        'specialization',
        'years_of_experience',
        'photo',
        'bio',
        'status',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_instructor')
            ->withPivot('role')
            ->withTimestamps();
    }
}
