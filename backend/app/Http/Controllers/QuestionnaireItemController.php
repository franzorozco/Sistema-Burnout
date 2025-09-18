<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionnaireItemRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class QuestionnaireItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaireItems = QuestionnaireItem::paginate();

        return view('admin.questionnaire-item.index', compact('questionnaireItems'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaireItems->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaireItem = new QuestionnaireItem();

        return view('admin.questionnaire-item.create', compact('questionnaireItem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireItemRequest $request): RedirectResponse
    {
        QuestionnaireItem::create($request->validated());

        return Redirect::route('admin.questionnaire-items.index')
            ->with('success', 'QuestionnaireItem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaireItem = QuestionnaireItem::find($id);

        return view('admin.questionnaire-item.show', compact('questionnaireItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaireItem = QuestionnaireItem::find($id);

        return view('admin.questionnaire-item.edit', compact('questionnaireItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireItemRequest $request, QuestionnaireItem $questionnaireItem): RedirectResponse
    {
        $questionnaireItem->update($request->validated());

        return Redirect::route('admin.questionnaire-items.index')
            ->with('success', 'QuestionnaireItem updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        QuestionnaireItem::find($id)->delete();

        return Redirect::route('admin.questionnaire-items.index')
            ->with('success', 'QuestionnaireItem deleted successfully');
    }
}
