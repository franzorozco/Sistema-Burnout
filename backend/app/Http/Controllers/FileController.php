<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FileController extends Controller
{
    public function index(Request $request): View
    {
        $files = File::paginate();

        return view('admin.file.index', compact('files'))
            ->with('i', ($request->input('page', 1) - 1) * $files->perPage());
    }

    public function create(): View
    {
        $file = new File();

        return view('admin.file.create', compact('file'));
    }

    public function store(FileRequest $request): RedirectResponse
    {
        File::create($request->validated());

        return Redirect::route('admin.files.index')
            ->with('success', 'File created successfully.');
    }

    public function show($id): View
    {
        $file = File::find($id);

        return view('admin.file.show', compact('file'));
    }

    public function edit($id): View
    {
        $file = File::find($id);

        return view('admin.file.edit', compact('file'));
    }

    public function update(FileRequest $request, File $file): RedirectResponse
    {
        $file->update($request->validated());

        return Redirect::route('admin.files.index')
            ->with('success', 'File updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        File::find($id)->delete();

        return Redirect::route('admin.files.index')
            ->with('success', 'File deleted successfully');
    }
}
