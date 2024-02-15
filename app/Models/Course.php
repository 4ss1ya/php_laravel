<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
public function users()
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
