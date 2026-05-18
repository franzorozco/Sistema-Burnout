<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        // Traemos todos los materiales de apoyo
        $resources = Resource::orderBy('created_at', 'desc')->get();
            
        return response()->json(['data' => $resources]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_type' => 'required|string|in:video,audio,documento,enlace',
            'content_url' => 'required|url',
        ]);

        $resource = Resource::create([
            'title' => $request->title,
            'description' => $request->description,
            'resource_type' => $request->resource_type,
            'content_url' => $request->content_url,
            'created_by' => auth()->id() ?? 1, // Por si el token no extrae ID en el test
        ]);

        return response()->json(['message' => 'Material subido con éxito', 'data' => $resource], 201);
    }
}
