<?php

declare(strict_types=1);

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\StoreURLRequest;
use App\Http\Requests\Url\UpdateURLRequest;
use App\Models\Url;
use App\Service\UrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UrlController extends Controller
{
    public function index(): JsonResponse
    {
        $urls = Auth::user()?->urls()->paginate();

        return response()->json([
            'urls' => $urls,
        ], status: Response::HTTP_OK);
    }

    public function store(StoreURLRequest $request, UrlService $service): JsonResponse
    {
        return response()->json([
            'url' => $service->create($request->validated()),
        ], status: Response::HTTP_CREATED);
    }

    public function show(Url $url): JsonResponse
    {
        return response()->json([
            'url' => $url,
        ], status: Response::HTTP_OK);
    }

    public function update(UpdateURLRequest $request, Url $url, UrlService $service): JsonResponse
    {
        $url->update($request->validated());

        return response()->json([
            'url' => $service->update($url, $request->validated()),
        ], status: Response::HTTP_OK);
    }

    public function destroy(Url $url): JsonResponse
    {
        $url->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
