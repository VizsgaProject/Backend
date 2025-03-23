<?php

namespace Database\Seeders;

use App\Models\Foods;
use App\Models\Workout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Foods
        try {
            $json = File::get('database/data/foods.json');
            $foods = json_decode($json);
            foreach ($foods as $value) {
                Foods::create([
                    'Name' => $value->Name,
                    'Img' => $value->Img,
                    'Weight' => $value->Weight,
                    'Calories' => $value->Calories,
                    'Protein' => $value->Protein,
                    'Carbohydrate' => $value->Carbohydrate,
                    'Fat' => $value->Fat,
                    'Type' => $value->Type,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to seed foods: ' . $e->getMessage());
        }

        // Seed Workouts
        try {
            $json = File::get('database/data/workouts.json');
            $workouts = json_decode($json);
            foreach ($workouts as $value) {
                Workout::create([
                    'MuscleGroup' => $value->MuscleGroup,
                    'Name' => $value->Name,
                    'Img' => $value->Img,
                    'Description' => $value->Description,
                    'Equipment' => $value->Equipment,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to seed workouts: ' . $e->getMessage());
        }
    }
}
