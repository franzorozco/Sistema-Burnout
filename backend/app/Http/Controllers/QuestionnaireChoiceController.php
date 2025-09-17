<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireChoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionnaireChoiceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionnaireChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaireChoices = QuestionnaireChoice::paginate();

        return view('questionnaire-choice.index', compact('questionnaireChoices'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaireChoices->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaireChoice = new QuestionnaireChoice();

        return view('questionnaire-choice.create', compact('questionnaireChoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireChoiceRequest $request): RedirectResponse
    {
        QuestionnaireChoice::create($request->validated());

        return Redirect::route('questionnaire-choices.index')
            ->with('success', 'QuestionnaireChoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaireChoice = QuestionnaireChoice::find($id);

        return view('questionnaire-choice.show', compact('questionnaireChoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaireChoice = QuestionnaireChoice::find($id);

        return view('questionnaire-choice.edit', compact('questionnaireChoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireChoiceRequest $request, QuestionnaireChoice $questionnaireChoice): RedirectResponse
    {
        $questionnaireChoice->update($request->validated());

        return Redirect::route('questionnaire-choices.index')
            ->with('success', 'QuestionnaireChoice updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        QuestionnaireChoice::find($id)->delete();

        return Redirect::route('questionnaire-choices.index')
            ->with('success', 'QuestionnaireChoice deleted successfully');
    }
}
