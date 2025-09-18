<?php

namespace App\Http\Controllers;

use App\Models\PostVote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PostVoteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $postVotes = PostVote::paginate();

        return view('admin.post-vote.index', compact('postVotes'))
            ->with('i', ($request->input('page', 1) - 1) * $postVotes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $postVote = new PostVote();

        return view('admin.post-vote.create', compact('postVote'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostVoteRequest $request): RedirectResponse
    {
        PostVote::create($request->validated());

        return Redirect::route('admin.post-votes.index')
            ->with('success', 'PostVote created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $postVote = PostVote::find($id);

        return view('admin.post-vote.show', compact('postVote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $postVote = PostVote::find($id);

        return view('admin.post-vote.edit', compact('postVote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostVoteRequest $request, PostVote $postVote): RedirectResponse
    {
        $postVote->update($request->validated());

        return Redirect::route('admin.post-votes.index')
            ->with('success', 'PostVote updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PostVote::find($id)->delete();

        return Redirect::route('admin.post-votes.index')
            ->with('success', 'PostVote deleted successfully');
    }
}
