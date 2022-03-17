<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => $this->faker->ean13(),
            'name' => $this->faker->word(),
            'unit_price' => $this->faker->randomFloat(2, 1, 150),
            'quantity' => $this->faker->numberBetween(1, 20),
        ];
    }
}
