<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use App\Models\ShortLink;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ShortLinkController extends Controller
{
    public function index(): View
    {
        $shortLinks = ShortLink::latest('id')->take(10)->get();

        return view('index', compact('shortLinks'));
    }

    public function store(ShortLinkRequest $request): JsonResponse
    {
        $shortLink = ShortLink::create($request->validated());

        return response()->json(['short_link' => $shortLink]);
    }
}
