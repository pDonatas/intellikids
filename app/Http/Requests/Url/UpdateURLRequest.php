<?php

declare(strict_types=1);

namespace App\Http\Requests\Url;

use App\Models\Url;
use App\Rules\UniqueUrl;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateURLRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check()
            && $this->route('url') instanceof Url
            && auth()->user()?->id === $this->route('url')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $url = $this->route('url');
        $id = $url instanceof Url ? $url->id : null;

        return [
            'long_url' => ['url'],
            'short_url' => ['string', new UniqueUrl($id)],
            'expires_at' => ['date_format:Y-m-d H:i'],
        ];
    }
}
