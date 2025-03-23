<?php

namespace Database\Factories\Company;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'document' => $this->faker->numberBetween(1000000, 10000000),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
