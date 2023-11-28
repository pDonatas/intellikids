<?php

declare(strict_types=1);

namespace App\Http\Requests\Url;

use App\Rules\UniqueUrl;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreURLRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'long_url' => ['required', 'url'],
            'short_url' => ['nullable', 'string', new UniqueUrl()],
            'expires_at' => ['nullable', 'date_format:Y-m-d H:i'],
        ];
    }
}
