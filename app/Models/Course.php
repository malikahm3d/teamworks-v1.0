<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function getCourses(User $user)
    {
        return $user->courses->pluck('id');
    }

}
