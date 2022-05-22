<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $with = [
        'caretaker', 
        'child'
    ];

    protected $fillable = [
        'caretaker_id',
        'child_id',
        'drop_off',
        'pick_up',
    ];

    public function caretaker()
    {
        return $this->belongsTo(User::class, 'caretaker_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }
}
