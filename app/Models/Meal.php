<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'breakfast',
        'lunch',
        'supper',
        'special',
    ];

    public function children()
    {
        return $this->hasMany(Child::class, 'meal_id');
    }
}
