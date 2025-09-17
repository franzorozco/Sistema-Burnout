<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionnaireResponseRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionnaireResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaireResponses = QuestionnaireResponse::paginate();

        return view('questionnaire-response.index', compact('questionnaireResponses'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaireResponses->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaireResponse = new QuestionnaireResponse();

        return view('questionnaire-response.create', compact('questionnaireResponse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireResponseRequest $request): RedirectResponse
    {
        QuestionnaireResponse::create($request->validated());

        return Redirect::route('questionnaire-responses.index')
            ->with('success', 'QuestionnaireResponse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaireResponse = QuestionnaireResponse::find($id);

        return view('questionnaire-response.show', compact('questionnaireResponse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaireResponse = QuestionnaireResponse::find($id);

        return view('questionnaire-response.edit', compact('questionnaireResponse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireResponseRequest $request, QuestionnaireResponse $questionnaireResponse): RedirectResponse
    {
        $questionnaireResponse->update($request->validated());

        return Redirect::route('questionnaire-responses.index')
            ->with('success', 'QuestionnaireResponse updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        QuestionnaireResponse::find($id)->delete();

        return Redirect::route('questionnaire-responses.index')
            ->with('success', 'QuestionnaireResponse deleted successfully');
    }
}
