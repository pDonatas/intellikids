<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Url;
use Illuminate\Support\Str;

class UrlService
{
    /**
     * @param array<string, string> $data
     */
    public function create(array $data): Url
    {
        if (! isset($data['short_url'])) {
            $data['short_url'] = $this->generateShortUrl();
        }

        $data['short_url'] = Str::slug($data['short_url']);
        $data['user_id'] = auth()->id();

        $url = Url::factory()->create($data);

        assert($url instanceof Url);

        return $url;
    }

    private function generateShortUrl(): string
    {
        $shortUrl = Str::random(6);

        if (Url::query()->where('short_url', $shortUrl)->exists()) {
            return $this->generateShortUrl();
        }

        return $shortUrl;
    }

    /**
     * @param array<string, string> $data
     */
    public function update(Url $url, array $data): Url
    {
        if (isset($data['short_url'])) {
            $data['short_url'] = Str::slug($data['short_url']);
        }

        $url->update($data);

        return $url;
    }
}
