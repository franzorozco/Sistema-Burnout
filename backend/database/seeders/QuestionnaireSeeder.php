<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Questionnaire;
use App\Models\QuestionnaireItem;
use App\Models\QuestionnaireChoice;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the questionnaire
        $questionnaire = Questionnaire::updateOrCreate(
            ['code' => 'BURNOUT_RAPIDO'],
            [
                'title' => 'Test Rápido de Burnout',
                'description' => 'Evaluación rápida de 10 preguntas para medir tu nivel de estrés y agotamiento.',
                'version' => '1.0',
                'is_pinned' => true,
            ]
        );

        $questions = [
            "¿Con qué frecuencia sientes agotamiento emocional por tus estudios?",
            "¿Sientes que tus estudios han dejado de tener sentido?",
            "¿Te resulta difícil relajarte después de un día de clases?",
            "¿Sientes que no logras lo suficiente a pesar de tu esfuerzo?",
            "¿Experimentas irritabilidad o frustración frecuente?",
            "¿Tienes dificultades para concentrarte en tus tareas?",
            "¿Sientes que tu energía se agota rápidamente?",
            "¿Te sientes desconectado/a de tus compañeros o actividades?",
            "¿Sientes que tu esfuerzo no es reconocido?",
            "¿Tienes problemas para dormir o descansas mal?",
        ];

        $likertChoices = [
            ['choice_order' => 1, 'value' => '1', 'label' => 'Nunca'],
            ['choice_order' => 2, 'value' => '2', 'label' => 'Casi Nunca'],
            ['choice_order' => 3, 'value' => '3', 'label' => 'A Veces'],
            ['choice_order' => 4, 'value' => '4', 'label' => 'Casi Siempre'],
            ['choice_order' => 5, 'value' => '5', 'label' => 'Siempre'],
        ];

        // Ensure we don't duplicate items if they already exist
        if ($questionnaire->items()->count() === 0) {
            foreach ($questions as $index => $text) {
                // 2. Create the questionnaire items
                $item = QuestionnaireItem::create([
                    'questionnaire_id' => $questionnaire->id,
                    'item_order' => $index + 1,
                    'question_text' => $text,
                    'response_type' => 'likert',
                ]);

                // 3. Create the questionnaire choices
                foreach ($likertChoices as $choice) {
                    QuestionnaireChoice::create(array_merge($choice, ['item_id' => $item->id]));
                }
            }
        }
    }
}
