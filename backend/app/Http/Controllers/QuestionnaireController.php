<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionnaireRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $questionnaires = Questionnaire::paginate();

        return view('admin.questionnaire.index', compact('questionnaires'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaires->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaire = new Questionnaire();
        $users = User::all();
        return view('admin.questionnaire.create', compact('questionnaire', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireRequest $request): RedirectResponse
    {
        Questionnaire::create($request->validated());

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Questionnaire created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaire = Questionnaire::find($id);

        return view('admin.questionnaire.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaire = Questionnaire::find($id);
        $users = User::all();
        return view('admin.questionnaire.edit', compact('questionnaire', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        $questionnaire->update($request->validated());

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Questionnaire updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Questionnaire::find($id)->delete();

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Questionnaire deleted successfully');
    }

    public function generateCode(Request $request)
    {
        $title = $request->input('title');

        // Convertir a mayúsculas, reemplazar espacios por guiones
        $baseCode = strtoupper(str_replace(' ', '-', $title));

        // Opcional: agregar número aleatorio o consecutivo
        $uniqueCode = $baseCode . '-' . rand(100, 999);

        return response()->json(['code' => $uniqueCode]);
    }

    public function generateVersion(Request $request)
    {
        $currentVersion = $request->input('current_version');
        $questionnaireId = $request->input('questionnaire_id');

        if ($questionnaireId && $currentVersion) {
            // Si ya existe, incrementar versión
            $parts = explode('.', $currentVersion);

            if (count($parts) == 2) {
                $major = (int)$parts[0];
                $minor = (int)$parts[1] + 1;
                $newVersion = $major . '.' . $minor;
            } else {
                $newVersion = $currentVersion . '.1'; // fallback
            }
        } else {
            // Si es nuevo, empezar en 1.0
            $newVersion = "1.0";
        }

        return response()->json(['version' => $newVersion]);
    }


}
