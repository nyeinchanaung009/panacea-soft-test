<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $conditions = ['new','second hand','display','damaged'];
        $types = ['for sell','for buy','for exchange'];

        return [
            'name' => explode(' ', trim(fake()->streetName()))[0],
            'category_id' => rand(1,11),
            'description' => fake()->sentence(),
            'price' => rand(10,300),
            'owner' => fake()->name(),
            'is_publish' => rand(0,1),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'image' => null,
            'condition' => $conditions[rand(0,3)],
            'type' => $types[rand(0,2)],
        ];
    }
}
