<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        $total = $this->faker->randomFloat(2, 1, 150);
        $totalWithDiscount = $total * 0.85;

        return [
            'code' => $this->faker->bothify("####-##-{$this->faker->numberBetween(1, 100)}"),
            'total' => $total,
            'total_with_discount' => $this->faker->randomElement([$total, $totalWithDiscount]),
        ];
    }
}
