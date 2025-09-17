<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $comments = Comment::paginate();

        return view('comment.index', compact('comments'))
            ->with('i', ($request->input('page', 1) - 1) * $comments->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $comment = new Comment();

        return view('comment.create', compact('comment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request): RedirectResponse
    {
        Comment::create($request->validated());

        return Redirect::route('comments.index')
            ->with('success', 'Comment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $comment = Comment::find($id);

        return view('comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $comment = Comment::find($id);

        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment): RedirectResponse
    {
        $comment->update($request->validated());

        return Redirect::route('comments.index')
            ->with('success', 'Comment updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Comment::find($id)->delete();

        return Redirect::route('comments.index')
            ->with('success', 'Comment deleted successfully');
    }
}
