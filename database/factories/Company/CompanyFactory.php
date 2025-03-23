<?php

namespace Database\Factories\Company;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->company;
        return [
            'city_id' => 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'document' => $this->faker->numberBetween(900000000, 9000000000),
            'address' => $this->faker->address,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
