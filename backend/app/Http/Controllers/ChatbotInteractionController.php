<?php

namespace App\Http\Controllers;

use App\Models\ChatbotInteraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ChatbotInteractionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ChatbotInteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $chatbotInteractions = ChatbotInteraction::paginate();

        return view('chatbot-interaction.index', compact('chatbotInteractions'))
            ->with('i', ($request->input('page', 1) - 1) * $chatbotInteractions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $chatbotInteraction = new ChatbotInteraction();

        return view('chatbot-interaction.create', compact('chatbotInteraction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatbotInteractionRequest $request): RedirectResponse
    {
        ChatbotInteraction::create($request->validated());

        return Redirect::route('chatbot-interactions.index')
            ->with('success', 'ChatbotInteraction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $chatbotInteraction = ChatbotInteraction::find($id);

        return view('chatbot-interaction.show', compact('chatbotInteraction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $chatbotInteraction = ChatbotInteraction::find($id);

        return view('chatbot-interaction.edit', compact('chatbotInteraction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChatbotInteractionRequest $request, ChatbotInteraction $chatbotInteraction): RedirectResponse
    {
        $chatbotInteraction->update($request->validated());

        return Redirect::route('chatbot-interactions.index')
            ->with('success', 'ChatbotInteraction updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ChatbotInteraction::find($id)->delete();

        return Redirect::route('chatbot-interactions.index')
            ->with('success', 'ChatbotInteraction deleted successfully');
    }
}
