<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'long_url',
        'short_url',
        'user_id',
        'expires_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime:Y-m-d H:i',
    ];

    /**
     * @return BelongsTo<User, Url>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Attribute<string, string >
     */
    public function shortUrl(): Attribute
    {
        return new Attribute(
            get: fn (string $url) => url("/{$url}")
        );
    }
}
