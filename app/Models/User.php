<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
public function courses()
{
    return $this->hasMany(UserCourse::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function quizzes()
{
    return $this->hasMany(Quiz::class);
}

    use HasFactory;
}
