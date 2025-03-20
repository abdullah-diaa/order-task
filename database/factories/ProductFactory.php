<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'sku' => strtoupper($this->faker->bothify('??-###')),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'status' => $this->faker->randomElement(['active', 'inactive', 'discontinued']),
            'discount_price' => $this->faker->randomFloat(2, 5, 200),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'stock' => $this->faker->numberBetween(0, 1000),
            
        ];
    }
}
