<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireResponse extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     */
    protected $table = 'questionnaire_responses';

    /**
     * Los atributos que se pueden asignar masivamente.
     * (¡ESTA ES LA PARTE MÁS IMPORTANTE DEL ARREGLO!)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'questionnaire_id',
        'student_profile_id',
        'user_id',
        'summary_score',
        'raw', // El JSON de respuestas
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto le dice a Laravel que 'raw' es un JSON.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'raw' => 'array', // o 'json'
        'submitted_at' => 'datetime',
    ];


    // --- El "Flujo de las Tablas" (Relaciones) ---

    /**
     * Obtiene el cuestionario al que pertenece esta respuesta.
     */
    public function questionnaire()
    {
        // Una respuesta pertenece a un cuestionario
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * Obtiene el usuario que envió esta respuesta (si aplica).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el perfil de estudiante que envió esta respuesta (si aplica).
     */
    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
