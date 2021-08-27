<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku'                  => $this->faker->name,
            'name'                 => $this->faker->name,
            'description'          => $this->faker->sentence,
            'unit_price'           => 100.00,
            'discount_price'       => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 50, $max = 90),
            'quantity_per_unit'    => 0,
            'units_in_stock'       => rand(0, 50),
            'units_on_order'       => rand(0, 50),
            'reorder_level'        => rand(0, 10),
            'is_taxable'           => true,
            'is_fulfilled'         => true,
            'is_available'         => true,
            'is_discountable'      => true,
            'is_active'            => true,
            'is_digital'           => true,
            'is_audio'             => true,
            'preacher_id'          => rand(1, 10),
            'date_preached'        => $this->faker->dateTime($max = 'now', $timezone = null),
            'size'                 => rand(20, 35),
            'format'               => 'audio',
            'download_link'        => $this->faker->url,
            's3_key'               => $this->faker->name,
            'file_size'            => $this->faker->name,
            'large_image_path'     => $this->faker->imageUrl($width = 800, $height = 800),
            'thumbnail_image_path' => $this->faker->imageUrl($width = 200, $height = 200),
        ];
    }
}
