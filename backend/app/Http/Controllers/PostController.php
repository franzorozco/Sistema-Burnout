<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $posts = $this->buildQuery($request)->paginate(15);

        return view('admin.post.index', compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * $posts->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $post = new Post();

        return view('admin.post.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): RedirectResponse
    {
        Post::create($request->validated());

        return Redirect::route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $post = Post::find($id);

        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $post = Post::find($id);

        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return Redirect::route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Post::find($id)->delete();

        return Redirect::route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }

    protected function buildQuery(Request $request)
    {
        $query = Post::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->has('is_anonymous') && $request->is_anonymous !== '') {
            $query->where('is_anonymous', $request->is_anonymous);
        }

        return $query->orderByDesc('id');
    }

    public function exportPdf(Request $request)
    {
        $posts = $this->buildQuery($request)->get();
        $filters = $request->only(['user_id','title','is_anonymous']);

        $pdf = Pdf::loadView('admin.post.pdf', compact('posts', 'filters'));

        return $pdf->download('posts_report_'.now()->format('Ymd_His').'.pdf');
    }
}
