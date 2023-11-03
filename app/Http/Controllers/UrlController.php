<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlCreateRequest;
use App\Http\Requests\UrlUpdateRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UrlResource::collection(Url::query()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlCreateRequest $request)
    {
        $url = Url::query()->create($request->validated());

        return new UrlResource($url);
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        return new UrlResource($url);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UrlUpdateRequest $request, Url $url)
    {
        $url->update($request->validated());

        return new UrlResource($url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        $url->delete();

        return response()->noContent();
    }
}
