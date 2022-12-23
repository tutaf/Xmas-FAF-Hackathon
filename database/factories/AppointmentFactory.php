<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Appointment;
use App\Models\Orhpan;
use App\Models\User;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orhpan_id' => Orhpan::factory(),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(["1","0","2"]),
            'date' => $this->faker->time(),
            'requirements' => $this->faker->word,
            'location' => $this->faker->word,
        ];
    }
}
