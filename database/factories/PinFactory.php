<?php

namespace Database\Factories;

use App\Models\Pin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pin = new Pin;

        return [
            'pin' => $pin->generatePIN(),
            'value' => 500,
            'value_used' => 0.00,
            'is_printed' => 0,
            'is_exhausted' => 0,
        ];
    }
}
