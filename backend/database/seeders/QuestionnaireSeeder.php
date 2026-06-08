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
        // 1. Create or update the questionnaire
        $questionnaire = Questionnaire::updateOrCreate(
            ['code' => 'BURNOUT_RAPIDO'],
            [
                'title' => 'Test Rápido de Burnout',
                'description' => 'Evaluación rápida de 10 preguntas para detectar signos de burnout académico.',
                'version' => '1.0',
                'is_pinned' => true,
            ]
        );

        // 2. Define the 10 questions
        $questions = [
            '¿Con qué frecuencia sientes agotamiento emocional por tus estudios?',
            '¿Sientes que tus estudios han dejado de tener sentido?',
            '¿Te resulta difícil relajarte después de un día de clases?',
            '¿Sientes que no logras lo suficiente a pesar de tu esfuerzo?',
            '¿Experimentas irritabilidad o frustración frecuente?',
            '¿Tienes dificultades para concentrarte en tus tareas?',
            '¿Sientes que tu energía se agota rápidamente?',
            '¿Te sientes desconectado/a de tus compañeros o actividades?',
            '¿Sientes que tu esfuerzo no es reconocido?',
            '¿Tienes problemas para dormir o descansas mal?',
        ];

        // 3. Likert choices definition
        $likertChoices = [
            ['choice_order' => 1, 'value' => '1', 'label' => 'Nunca'],
            ['choice_order' => 2, 'value' => '2', 'label' => 'Casi Nunca'],
            ['choice_order' => 3, 'value' => '3', 'label' => 'A Veces'],
            ['choice_order' => 4, 'value' => '4', 'label' => 'Casi Siempre'],
            ['choice_order' => 5, 'value' => '5', 'label' => 'Siempre'],
        ];

        // 4. Create items and choices
        foreach ($questions as $index => $questionText) {
            $item = QuestionnaireItem::updateOrCreate(
                [
                    'questionnaire_id' => $questionnaire->id,
                    'item_order' => $index + 1,
                ],
                [
                    'question_text' => $questionText,
                    'response_type' => 'likert',
                ]
            );

            // Create choices for each item
            foreach ($likertChoices as $choice) {
                QuestionnaireChoice::updateOrCreate(
                    [
                        'item_id' => $item->id,
                        'choice_order' => $choice['choice_order'],
                    ],
                    [
                        'value' => $choice['value'],
                        'label' => $choice['label'],
                    ]
                );
            }
        }
    }
}
