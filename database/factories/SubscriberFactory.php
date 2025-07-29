<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
        return [
            'email'         => $this->faker->unique()->safeEmail(),
            'subscribed_at' => now()->subDays(random_int(0, 365)),
        ];
    }
}
