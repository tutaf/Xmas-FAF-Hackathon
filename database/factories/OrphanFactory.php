<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Orphan;

class OrphanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orphan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orphanage_id' => $this->faker->word,
            'firstName' => $this->faker->word,
            'lastName' => $this->faker->word,
            'birthsday' => $this->faker->word,
            'image' => $this->faker->word,
            'text' => $this->faker->word,
        ];
    }
}
