<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireItem;
use App\Models\QuestionnaireChoice;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuestionnaireController extends Controller
{
    // GET /api/questionnaires - list all
    public function index(): JsonResponse
    {
        $questionnaires = Questionnaire::withCount(['items', 'questionnaireResponses'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['data' => $questionnaires]);
    }

    // GET /api/questionnaires/pinned - get the pinned one with items+choices
    public function pinned(): JsonResponse
    {
        $q = Questionnaire::where('is_pinned', true)
            ->with(['items' => function($query) {
                $query->orderBy('item_order')->with('choices');
            }])
            ->first();
        if (!$q) {
            return response()->json(['error' => 'No hay test fijado'], 404);
        }
        return response()->json(['data' => $q]);
    }

    // GET /api/questionnaires/{id} - get one with items+choices  
    public function show($id): JsonResponse
    {
        $q = Questionnaire::with(['items' => function($query) {
            $query->orderBy('item_order')->with('choices');
        }])->findOrFail($id);
        return response()->json(['data' => $q]);
    }

    // POST /api/questionnaires - create
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $q = Questionnaire::create([
            'code' => strtoupper(str_replace(' ', '_', $request->title)) . '_' . rand(100,999),
            'title' => $request->title,
            'description' => $request->description,
            'version' => '1.0',
            'is_pinned' => false,
        ]);
        return response()->json(['data' => $q], 201);
    }

    // PUT /api/questionnaires/{id} - update
    public function update(Request $request, $id): JsonResponse
    {
        $q = Questionnaire::findOrFail($id);
        $q->update($request->only(['title', 'description', 'version']));
        return response()->json(['data' => $q]);
    }

    // DELETE /api/questionnaires/{id}
    public function destroy($id): JsonResponse
    {
        $q = Questionnaire::findOrFail($id);
        $q->delete();
        return response()->json(['message' => 'Eliminado']);
    }

    // PUT /api/questionnaires/{id}/pin - set as pinned (unpin others)
    public function pin($id): JsonResponse
    {
        Questionnaire::where('is_pinned', true)->update(['is_pinned' => false]);
        $q = Questionnaire::findOrFail($id);
        $q->update(['is_pinned' => true]);
        return response()->json(['data' => $q]);
    }

    // POST /api/questionnaires/{id}/items - add question
    public function addItem(Request $request, $id): JsonResponse
    {
        $q = Questionnaire::findOrFail($id);
        $request->validate([
            'question_text' => 'required|string',
            'response_type' => 'nullable|string',
            'choices' => 'nullable|array',
            'choices.*.value' => 'required|string',
            'choices.*.label' => 'required|string',
        ]);
        $maxOrder = $q->items()->max('item_order') ?? 0;
        $responseType = $request->response_type ?? 'likert';
        
        $item = QuestionnaireItem::create([
            'questionnaire_id' => $q->id,
            'item_order' => $maxOrder + 1,
            'question_text' => $request->question_text,
            'response_type' => $responseType,
        ]);
        
        if (in_array($responseType, ['likert', 'opcion']) && $request->has('choices')) {
            foreach ($request->choices as $index => $c) {
                QuestionnaireChoice::create([
                    'item_id' => $item->id,
                    'choice_order' => $index + 1,
                    'value' => $c['value'],
                    'label' => $c['label'],
                ]);
            }
        } elseif ($responseType === 'likert') {
            // Default Likert choices
            $likert = [
                ['choice_order' => 1, 'value' => '1', 'label' => 'Nunca'],
                ['choice_order' => 2, 'value' => '2', 'label' => 'Casi Nunca'],
                ['choice_order' => 3, 'value' => '3', 'label' => 'A Veces'],
                ['choice_order' => 4, 'value' => '4', 'label' => 'Casi Siempre'],
                ['choice_order' => 5, 'value' => '5', 'label' => 'Siempre'],
            ];
            foreach ($likert as $c) {
                QuestionnaireChoice::create(array_merge($c, ['item_id' => $item->id]));
            }
        }
        $item->load('choices');
        return response()->json(['data' => $item], 201);
    }

    // PUT /api/questionnaires/{id}/items/{itemId} - update question
    public function updateItem(Request $request, $id, $itemId): JsonResponse
    {
        $item = QuestionnaireItem::where('questionnaire_id', $id)->findOrFail($itemId);
        
        $request->validate([
            'question_text' => 'required|string',
            'response_type' => 'nullable|string',
            'choices' => 'nullable|array',
            'choices.*.value' => 'required|string',
            'choices.*.label' => 'required|string',
        ]);

        $item->update($request->only(['question_text', 'item_order', 'response_type']));
        
        if (in_array($item->response_type, ['likert', 'opcion']) && $request->has('choices')) {
            $item->choices()->delete();
            foreach ($request->choices as $index => $c) {
                QuestionnaireChoice::create([
                    'item_id' => $item->id,
                    'choice_order' => $index + 1,
                    'value' => $c['value'],
                    'label' => $c['label'],
                ]);
            }
        } elseif (!in_array($item->response_type, ['likert', 'opcion'])) {
            $item->choices()->delete();
        }

        $item->load('choices');
        return response()->json(['data' => $item]);
    }

    // DELETE /api/questionnaires/{id}/items/{itemId} - delete question
    public function deleteItem($id, $itemId): JsonResponse
    {
        $item = QuestionnaireItem::where('questionnaire_id', $id)->findOrFail($itemId);
        $item->delete();
        // Reorder remaining items
        $items = QuestionnaireItem::where('questionnaire_id', $id)->orderBy('item_order')->get();
        foreach ($items as $i => $it) {
            $it->update(['item_order' => $i + 1]);
        }
        return response()->json(['message' => 'Pregunta eliminada']);
    }

    // GET /api/questionnaire-responses-stats/{id} - response statistics
    public function responseStats($id): JsonResponse
    {
        $responses = QuestionnaireResponse::where('questionnaire_id', $id)->get();
        $total = $responses->count();
        $avgScore = $total > 0 ? round($responses->avg('summary_score'), 1) : 0;
        $bien = $responses->where('summary_score', '<=', 20)->count();
        $atencion = $responses->whereBetween('summary_score', [21, 35])->count();
        $prioridad = $responses->where('summary_score', '>', 35)->count();

        return response()->json([
            'total' => $total,
            'avg_score' => $avgScore,
            'distribution' => [
                'bien' => $bien,
                'atencion' => $atencion,
                'prioridad' => $prioridad,
            ],
            'responses' => $responses->map(function($r) {
                return [
                    'id' => $r->id,
                    'summary_score' => $r->summary_score,
                    'submitted_at' => $r->submitted_at ?? $r->created_at,
                    'user_id' => $r->user_id,
                ];
            })->sortByDesc('submitted_at')->values(),
        ]);
    }
}
