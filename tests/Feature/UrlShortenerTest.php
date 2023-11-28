<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    private readonly User $user;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->user = User::factory()->create();
    }

    public function test_url_shortener_takes_long_url_and_returns_short_url(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('urls.store'), [
            'long_url' => 'https://www.google.com',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'url' => [
                'long_url',
                'short_url',
                'user_id',
                'expires_at',
                'id',
            ],
        ]);
    }

    public function test_user_can_specify_short_url(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('urls.store'), [
            'long_url' => 'https://www.google.com',
            'short_url' => 'google',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'url' => [
                'long_url',
                'short_url',
                'user_id',
                'expires_at',
                'id',
            ],
        ]);
    }

    public function test_user_can_delete_url_before_expiration(): void
    {
        $url = $this->createUrl();

        $response = $this->actingAs($this->user)->deleteJson(route('urls.destroy', $url));

        $response->assertNoContent();
    }

    public function test_can_not_access_expired_link(): void
    {
        $url = $this->createUrl(['expires_at' => now()->subDay()]);

        $response = $this->get($url->short_url);

        $response->assertNotFound();
    }

    public function test_url_can_be_shortened(): void
    {
        $url = $this->createUrl();

        $this->assertDatabaseHas('urls', [
            'long_url' => $url->long_url,
            'short_url' => $url->getRawOriginal('short_url'),
            'user_id' => $url->user_id,
            'expires_at' => $url->expires_at?->format('Y-m-d H:i:s')
        ]);
    }

    public function test_shortened_url_redirects(): void
    {
        $url = $this->createUrl();

        $response = $this->get($url->short_url);

        $response->assertRedirect($url->long_url);
    }

    public function test_shortened_url_increments_visits(): void
    {
        $url = $this->createUrl();

        $this->get($url->short_url);

        $this->assertEquals(1, $url->fresh()?->visits);
    }

    public function test_shortened_url_with_expiration_date_redirects(): void
    {
        $url = $this->createUrl(['expires_at' => now()->subDay()]);

        $response = $this->get($url->short_url);

        $response->assertNotFound();
    }

    public function test_shortened_url_with_expiration_date_does_not_increment_visits(): void
    {
        $url = $this->createUrl(['expires_at' => now()->subDay()]);

        $this->get($url->short_url);

        $this->assertEquals(0, $url->fresh()?->visits);
    }

    public function test_shortened_url_with_expiration_date_can_be_visited_before_expiration(): void
    {
        $url = $this->createUrl(['expires_at' => now()->addDay()]);

        $response = $this->get($url->short_url);

        $response->assertRedirect($url->long_url);
    }

    /**
     * @param array<string, string> $attributes
     * @return Url
     */
    private function createUrl(array $attributes = []): Url
    {
        $url =  Url::factory()->create($attributes);

        assert($url instanceof Url);

        return $url;
    }
}
