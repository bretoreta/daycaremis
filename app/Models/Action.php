<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsible_role',
        'responsible_user',
        'action_done',
        'affected_record',
    ];

    /**
     * Get the affected record.
     *
     * @param  string  $value
     * @return string
     */
    public function getAffectedRecordAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the responsible user.
     *
     * @param  string  $value
     * @return string
     */
    public function getResponsibleUserAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
