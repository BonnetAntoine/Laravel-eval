<?php

namespace Database\Factories\Commun;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Planning\Tache>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::random(10);

        return [
            'name' => $name,
            'title' => Str::slug($name),
        ];
    }
}
