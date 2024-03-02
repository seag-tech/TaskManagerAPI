<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $random     = rand(0, 1);
        $dueDate    = null;

        if ($random) {
            $dueDate = $this->faker->dateTimeBetween('now', '+1 year');
        }

        return [
            'title'         => $this->faker->jobTitle,
            'description'   => $this->faker->paragraph,
            'completed'     => false,
            'due_date'      => $dueDate,
        ];
    }
}
