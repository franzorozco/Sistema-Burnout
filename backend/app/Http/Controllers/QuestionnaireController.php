<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\QuestionnaireItem;
use App\Models\QuestionnaireChoice;
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
        $questionnaires = Questionnaire::withCount(['items', 'questionnaireResponses'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('admin.questionnaire.index', compact('questionnaires'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaires->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $questionnaire = new Questionnaire();
        $questionnaire->version = '1.0';
        $questionnaire->is_pinned = false;
        $users = User::all();
        return view('admin.questionnaire.create', compact('questionnaire', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionnaireRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['code'] = strtoupper(str_replace(' ', '_', $data['title'])) . '_' . rand(100, 999);
        
        $questionnaire = Questionnaire::create($data);
        
        // Guardar items si se enviaron
        $this->saveItems($questionnaire, $request->input('items', []));

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Cuestionario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $questionnaire = Questionnaire::with(['items' => function($query) {
            $query->orderBy('item_order')->with('choices');
        }])->findOrFail($id);

        return view('admin.questionnaire.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $questionnaire = Questionnaire::with(['items' => function($query) {
            $query->orderBy('item_order')->with('choices');
        }])->findOrFail($id);
        
        $items = $questionnaire->items->map(function ($item) {
            return [
                'id' => $item->id,
                'question_text' => $item->question_text,
                'response_type' => $item->response_type,
                'item_order' => $item->item_order,
                'choices' => $item->choices->map(fn($c) => ['id' => $c->id, 'label' => $c->label, 'value' => $c->value])->toArray(),
                'meta' => json_decode($item->meta, true),
            ];
        })->toArray();

        $users = User::all();
        return view('admin.questionnaire.edit', compact('questionnaire', 'users', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire): RedirectResponse
    {
        $data = $request->validated();
        $questionnaire->update($data);
        
        // Guardar/actualizar items
        $this->saveItems($questionnaire, $request->input('items', []));

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Cuestionario actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Questionnaire::find($id)->delete();

        return Redirect::route('admin.questionnaires.index')
            ->with('success', 'Cuestionario eliminado exitosamente');
    }

    public function generateCode(Request $request)
    {
        $title = $request->input('title');

        $baseCode = strtoupper(str_replace(' ', '_', $title));
        $uniqueCode = $baseCode . '_' . rand(100, 999);

        return response()->json(['code' => $uniqueCode]);
    }

    public function generateVersion(Request $request)
    {
        $currentVersion = $request->input('current_version');
        $questionnaireId = $request->input('questionnaire_id');

        if ($questionnaireId && $currentVersion) {
            $parts = explode('.', $currentVersion);

            if (count($parts) == 2) {
                $major = (int)$parts[0];
                $minor = (int)$parts[1] + 1;
                $newVersion = $major . '.' . $minor;
            } else {
                $newVersion = $currentVersion . '.1';
            }
        } else {
            $newVersion = "1.0";
        }

        return response()->json(['version' => $newVersion]);
    }

    /**
     * Guardar/actualizar items del cuestionario
     */
    private function saveItems(Questionnaire $questionnaire, array $itemsData): void
    {
        $sentItemIds = [];

        foreach ($itemsData as $index => $itemData) {
            $meta = [];

            if (($itemData['response_type'] ?? '') === 'numero') {
                $meta['min'] = $itemData['meta']['min'] ?? null;
                $meta['max'] = $itemData['meta']['max'] ?? null;
            } elseif (in_array($itemData['response_type'] ?? '', ['opcion', 'likert'])) {
                $meta['choices'] = $itemData['choices'] ?? [];
            }

            if (!empty($itemData['id'])) {
                $item = QuestionnaireItem::find($itemData['id']);
                if ($item && $item->questionnaire_id === $questionnaire->id) {
                    $item->update([
                        'question_text' => $itemData['question_text'],
                        'response_type' => $itemData['response_type'],
                        'item_order' => $itemData['item_order'] ?? $index + 1,
                        'meta' => json_encode($meta),
                    ]);
                }
            } else {
                $item = QuestionnaireItem::create([
                    'questionnaire_id' => $questionnaire->id,
                    'question_text' => $itemData['question_text'],
                    'response_type' => $itemData['response_type'],
                    'item_order' => $itemData['item_order'] ?? $index + 1,
                    'meta' => json_encode($meta),
                ]);
            }

            $sentItemIds[] = $item->id;
            $sentChoiceIds = [];

            if (isset($itemData['choices'])) {
                foreach ($itemData['choices'] as $order => $choiceData) {
                    if (!empty($choiceData['id']) && is_numeric($choiceData['id'])) {
                        $choice = QuestionnaireChoice::find($choiceData['id']);
                        if ($choice && $choice->item_id === $item->id) {
                            $choice->update([
                                'label' => $choiceData['label'],
                                'value' => $choiceData['value'] ?? $choiceData['label'],
                                'choice_order' => $order + 1,
                            ]);
                        }
                    } else {
                        $choice = QuestionnaireChoice::create([
                            'item_id' => $item->id,
                            'label' => $choiceData['label'],
                            'value' => $choiceData['value'] ?? $choiceData['label'],
                            'choice_order' => $order + 1,
                        ]);
                    }
                    $sentChoiceIds[] = $choice->id;
                }
            }

            QuestionnaireChoice::where('item_id', $item->id)
                ->whereNotIn('id', $sentChoiceIds)
                ->delete();
        }

        QuestionnaireItem::where('questionnaire_id', $questionnaire->id)
            ->whereNotIn('id', $sentItemIds)
            ->delete();
    }
}
