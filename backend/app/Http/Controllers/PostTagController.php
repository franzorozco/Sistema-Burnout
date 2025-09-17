<?php

namespace App\Http\Controllers;

use App\Models\PostTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PostTagRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $postTags = PostTag::paginate();

        return view('post-tag.index', compact('postTags'))
            ->with('i', ($request->input('page', 1) - 1) * $postTags->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $postTag = new PostTag();

        return view('post-tag.create', compact('postTag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostTagRequest $request): RedirectResponse
    {
        PostTag::create($request->validated());

        return Redirect::route('post-tags.index')
            ->with('success', 'PostTag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $postTag = PostTag::find($id);

        return view('post-tag.show', compact('postTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $postTag = PostTag::find($id);

        return view('post-tag.edit', compact('postTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostTagRequest $request, PostTag $postTag): RedirectResponse
    {
        $postTag->update($request->validated());

        return Redirect::route('post-tags.index')
            ->with('success', 'PostTag updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PostTag::find($id)->delete();

        return Redirect::route('post-tags.index')
            ->with('success', 'PostTag deleted successfully');
    }
}
