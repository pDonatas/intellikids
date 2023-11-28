<?php

declare(strict_types=1);

namespace App\Http\Controllers\Routing;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\RedirectResponse;

class RoutingController extends Controller
{
    public function __invoke(Url $url): RedirectResponse
    {
        if ($url->expires_at && $url->expires_at->isPast()) {
            abort(404);
        }

        $url->increment('visits');

        return redirect($url->long_url);
    }
}
