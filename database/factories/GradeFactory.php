<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

<<<<<<< HEAD
class GradeFactory extends Factory
{
    protected $model = Grade::class;

=======
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    protected $model = Grade::class;
 
>>>>>>> acb911e (student dashboard)
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
<<<<<<< HEAD
}
=======
}
>>>>>>> acb911e (student dashboard)
