<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'university_id',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
