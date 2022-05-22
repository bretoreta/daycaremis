<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "dob",
        "gender",
        "user_id",
        "meal_id",
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'child_id');
    }
}
