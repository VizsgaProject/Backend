<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $table = 'workouts';

    public $timestamps = false;

    protected $fillable = [
        'muscleGroup',
        'name',
        'shortDescription',
        'description',
        'equipment',
    ];
}
