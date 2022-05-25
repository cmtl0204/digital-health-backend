<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\User;
use App\Models\Core\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sexes = Catalogue::where('type', 'SEX_TYPE')->get();
        $genders = Catalogue::where('type', 'GENDER_TYPE')->get();
        return [
            'username' => $this->faker->numberBetween(1111111111, 999999999),
            'name' => $this->faker->name(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birthdate' => '04-12-1990',
            'sex_id' => $this->faker->randomElement($sexes),
            'gender_id' => $this->faker->randomElement($genders),
            'email_verified_at' => now(),
            'password' => '12345678',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
