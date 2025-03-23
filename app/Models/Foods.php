<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;

    protected $table = 'foods';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'img',
        'weight',
        'calories',
        'protein',
        'carbohydrate',
        'fat',
        'type',
    ];

    // 1 -> N kapcsolat a UserWeeklyFood modellhez
    public function userWeeklyFood()
    {
        return $this->hasMany(UserWeeklyFood::class);
    }
}
