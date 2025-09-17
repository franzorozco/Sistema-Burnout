<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionnaireRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaires = Questionnaire::paginate();

        return view('questionnaire.index', compact('questionnaires'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaires->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaire = new Questionnaire();

        return view('questionnaire.create', compact('questionnaire'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireRequest $request): RedirectResponse
    {
        Questionnaire::create($request->validated());

        return Redirect::route('questionnaires.index')
            ->with('success', 'Questionnaire created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaire = Questionnaire::find($id);

        return view('questionnaire.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaire = Questionnaire::find($id);

        return view('questionnaire.edit', compact('questionnaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        $questionnaire->update($request->validated());

        return Redirect::route('questionnaires.index')
            ->with('success', 'Questionnaire updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Questionnaire::find($id)->delete();

        return Redirect::route('questionnaires.index')
            ->with('success', 'Questionnaire deleted successfully');
    }
}
