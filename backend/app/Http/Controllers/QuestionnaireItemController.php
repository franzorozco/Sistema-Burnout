<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Questionnaire;
use App\Models\QuestionnaireChoice;

class QuestionnaireItemController extends Controller
{
    public function index(Request $request): View
    {
        $questionnaireItems = QuestionnaireItem::paginate();

        return view('admin.questionnaire-item.index', compact('questionnaireItems'))
            ->with('i', ($request->input('page', 1) - 1) * $questionnaireItems->perPage());
    }

    public function create(): View
    {
        $questionnaireItem = new QuestionnaireItem();
        $questionnaires = Questionnaire::all();
        return view('admin.questionnaire-item.create', compact('questionnaireItem', 'questionnaires'));
    }

    protected function prepareMeta(array $data)
    {
        $meta = [];

        if ($data['response_type'] === 'numero') {
            $meta['min'] = $data['meta']['min'] ?? null;
            $meta['max'] = $data['meta']['max'] ?? null;
        }

        if (in_array($data['response_type'], ['opcion', 'likert'])) {
            $meta['choices'] = $data['choices'] ?? [];
        }

        return json_encode($meta);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data['items'] as $itemData) {
            $meta = [];

            if ($itemData['response_type'] === 'numero') {
                $meta['min'] = $itemData['meta']['min'] ?? null;
                $meta['max'] = $itemData['meta']['max'] ?? null;
            } elseif (in_array($itemData['response_type'], ['opcion', 'likert'])) {
                $meta['choices'] = $itemData['choices'] ?? [];
            }

            $item = QuestionnaireItem::create([
                'questionnaire_id' => $request->questionnaire_id,
                'item_order'       => $itemData['item_order'] ?? 1,
                'question_text'    => $itemData['question_text'],
                'response_type'    => $itemData['response_type'],
                'meta'             => json_encode($meta),
            ]);

            if (isset($itemData['choices'])) {
                foreach ($itemData['choices'] as $order => $choice) {
                    $item->choices()->create([
                        'choice_order' => $order + 1,
                        'label'        => $choice['label'],
                        'value'        => $choice['value'] ?? $choice['label'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.questionnaire-items.index')
            ->with('success', 'Ítems guardados correctamente.');
    }

    public function show($id): View
    {
        $questionnaireItem = QuestionnaireItem::find($id);
        return view('admin.questionnaire-item.show', compact('questionnaireItem'));
    }

    public function edit(QuestionnaireItem $questionnaireItem)
    {
        $questionnaires = Questionnaire::all();
        $items = $questionnaireItem->questionnaire->items()
            ->with('choices')
            ->orderBy('item_order')
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'question_text' => $item->question_text,
                    'response_type' => $item->response_type,
                    'item_order'    => $item->item_order,
                    'choices'       => $item->choices->map(fn($c) => ['label' => $c->label, 'value' => $c->value])->toArray(),
                    'meta'          => json_decode($item->meta, true),
                ];
            })->toArray();

        return view('admin.questionnaire-item.edit', compact('questionnaireItem', 'questionnaires', 'items'));
    }

    public function update(Request $request, QuestionnaireItem $questionnaireItem)
    {
        $data = $request->all();
        $sentItemIds = [];

        foreach ($data['items'] as $itemData) {
            $meta = [];

            if ($itemData['response_type'] === 'numero') {
                $meta['min'] = $itemData['meta']['min'] ?? null;
                $meta['max'] = $itemData['meta']['max'] ?? null;
            } elseif (in_array($itemData['response_type'], ['opcion', 'likert'])) {
                $meta['choices'] = $itemData['choices'] ?? [];
            }

            if (!empty($itemData['id'])) {
                $item = QuestionnaireItem::find($itemData['id']);
                $item->update([
                    'questionnaire_id' => $itemData['questionnaire_id'] ?? $questionnaireItem->questionnaire_id,
                    'question_text'    => $itemData['question_text'],
                    'response_type'    => $itemData['response_type'],
                    'item_order'       => $itemData['item_order'] ?? 1,
                    'meta'             => json_encode($meta),
                ]);
            } else {
                $item = QuestionnaireItem::create([
                    'questionnaire_id' => $itemData['questionnaire_id'] ?? $questionnaireItem->questionnaire_id,
                    'question_text'    => $itemData['question_text'],
                    'response_type'    => $itemData['response_type'],
                    'item_order'       => $itemData['item_order'] ?? 1,
                    'meta'             => json_encode($meta),
                ]);
            }

            $sentItemIds[] = $item->id;
            $sentChoiceIds = [];

            if (isset($itemData['choices'])) {
                foreach ($itemData['choices'] as $order => $choiceData) {
                    if (!empty($choiceData['id']) && is_numeric($choiceData['id'])) {
                        $choice = QuestionnaireChoice::find($choiceData['id']);
                        if ($choice) {
                            $choice->update([
                                'label'        => $choiceData['label'],
                                'value'        => $choiceData['value'] ?? $choiceData['label'],
                                'choice_order' => $order + 1,
                            ]);
                        }
                    } else {
                        $choice = QuestionnaireChoice::create([
                            'item_id'      => $item->id,
                            'label'        => $choiceData['label'],
                            'value'        => $choiceData['value'] ?? $choiceData['label'],
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

        QuestionnaireItem::where('questionnaire_id', $questionnaireItem->questionnaire_id)
            ->whereNotIn('id', $sentItemIds)
            ->delete();

        return redirect()->route('admin.questionnaire-items.index')
            ->with('success', 'Cuestionario actualizado correctamente.');
    }

    public function destroy($id): RedirectResponse
    {
        QuestionnaireItem::find($id)->delete();
        return Redirect::route('admin.questionnaire-items.index')
            ->with('success', 'QuestionnaireItem deleted successfully');
    }

    private function saveChoices(int $itemId, array $data)
    {
        QuestionnaireChoice::where('item_id', $itemId)->delete();

        if (in_array($data['response_type'], ['likert','opcion']) && isset($data['choices'])) {
            foreach ($data['choices'] as $order => $choice) {
                $label = trim($choice['label'] ?? '');
                $value = trim($choice['value'] ?? $label);

                if ($label !== '') {
                    QuestionnaireChoice::create([
                        'item_id'      => $itemId,
                        'choice_order' => $order + 1,
                        'label'        => $label,
                        'value'        => $value,
                    ]);
                }
            }
        }
    }

    public function getNextOrder($questionnaireId)
    {
        $maxOrder = QuestionnaireItem::where('questionnaire_id', $questionnaireId)->max('item_order') ?? 0;
        return response()->json(['next_order' => $maxOrder + 1]);
    }
}
