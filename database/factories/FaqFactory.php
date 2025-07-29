<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question'  => $this->faker->sentence(),
            'answer'    => $this->faker->paragraph(),
            'is_active' => true,
        ];
    }
}
