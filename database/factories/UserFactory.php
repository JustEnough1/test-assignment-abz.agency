<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->generatePhoneNumber(),
            'position_id' => Position::all('id')->random(),
            'photo' => "default.jpg"
        ];
    }

    private function generatePhoneNumber()
    {
        $countryCode = '+380';
        $phoneNumberFormat = $countryCode . ' ### ### ####';
        return fake()->unique()->numerify($phoneNumberFormat);
    }
}
