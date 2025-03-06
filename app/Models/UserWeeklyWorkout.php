<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWeeklyWorkout extends Model
{
    use HasFactory;

    protected $table = 'user_weekly_workouts';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'workout_id',
        'dayOfWeek',
        'reps',
        'sets',
        'date',
    ];

    // 1 -> N
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id', 'id');
    }
}
