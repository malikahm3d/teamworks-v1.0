<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Likeable;

class Post extends Model
{
    use HasFactory;
    use Likeable;


    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner(User $user)
    {
        return $this->user_id === $user->id;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
        //return $this->hasMany(Comment::class)->whereNull(parent_id);
    }

    public function file()
    {
        return $this->hasMany(File::class);
    }


    public function answered()
    {
        return $this->commnt_id != null;
    }

}
