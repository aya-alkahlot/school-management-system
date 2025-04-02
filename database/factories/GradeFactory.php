<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;


    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'Name' => [
                'en' => $this->faker->unique()->word,
                'ar' => $this->faker->unique()->word,
            ],
            'Notes' => $this->faker->sentence(),
        ];
    }
}