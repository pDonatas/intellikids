<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Url;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Url>
 */
class UrlFactory extends Factory
{
    protected $model = Url::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'long_url' => $this->faker->url,
            'short_url' => $this->faker->unique()->slug,
            'user_id' => User::inRandomOrder()->first()?->id,
            'expires_at' => now()->addDays(7),
        ];
    }
}
