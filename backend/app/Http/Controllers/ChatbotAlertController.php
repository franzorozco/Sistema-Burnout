<?php

namespace App\Http\Controllers;

use App\Models\ChatbotAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ChatbotAlertRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ChatbotAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $chatbotAlerts = ChatbotAlert::paginate();

        return view('chatbot-alert.index', compact('chatbotAlerts'))
            ->with('i', ($request->input('page', 1) - 1) * $chatbotAlerts->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $chatbotAlert = new ChatbotAlert();

        return view('chatbot-alert.create', compact('chatbotAlert'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatbotAlertRequest $request): RedirectResponse
    {
        ChatbotAlert::create($request->validated());

        return Redirect::route('chatbot-alerts.index')
            ->with('success', 'ChatbotAlert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $chatbotAlert = ChatbotAlert::find($id);

        return view('chatbot-alert.show', compact('chatbotAlert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $chatbotAlert = ChatbotAlert::find($id);

        return view('chatbot-alert.edit', compact('chatbotAlert'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChatbotAlertRequest $request, ChatbotAlert $chatbotAlert): RedirectResponse
    {
        $chatbotAlert->update($request->validated());

        return Redirect::route('chatbot-alerts.index')
            ->with('success', 'ChatbotAlert updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ChatbotAlert::find($id)->delete();

        return Redirect::route('chatbot-alerts.index')
            ->with('success', 'ChatbotAlert deleted successfully');
    }
}
