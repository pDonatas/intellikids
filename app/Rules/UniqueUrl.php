<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Url;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueUrl implements ValidationRule
{
    public function __construct(
        private readonly ?int $id = null
    ) {}

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($this->id) {
            $url = Url::whereShortUrl(Str::slug($value))->where('id', '!=', $this->id)->first();
        } else {
            $url = Url::whereShortUrl(Str::slug($value))->first();
        }

        if ($url) {
            $fail('The :attribute has already been taken.');
        }
    }
}
