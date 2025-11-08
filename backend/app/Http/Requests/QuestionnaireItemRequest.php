<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'questionnaire_id' => 'required|exists:questionnaires,id',
            'item_order' => 'required|integer',
            'question_text' => 'required|string',
            'response_type' => 'required|string|in:likert,booleano,numero,texto,opcion',
            'choices' => 'sometimes|array',
            'choices.*.label' => 'required_with:choices|string',
            'choices.*.value' => 'nullable|string',
            'meta.min' => 'nullable|numeric',
            'meta.max' => 'nullable|numeric',
        ];
    }

}
