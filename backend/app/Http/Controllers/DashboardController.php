<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Usuarios por mes
        $usersByMonth = DB::table('users')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 2. Roles
        $roles = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name', DB::raw('COUNT(*) AS total'))
            ->groupBy('roles.name')
            ->get();

        // 3. Profesionales
        $professions = DB::table('professionals')
            ->select('profession', DB::raw('COUNT(*) as total'))
            ->groupBy('profession')
            ->get();

        // 4. Estado de ánimo
        $moods = DB::table('state_reports')
            ->select('mood', DB::raw('COUNT(*) as total'))
            ->groupBy('mood')
            ->get();

        // 5. Estrés medio por mes
        $stressMonth = DB::table('state_reports')
            ->selectRaw("DATE_FORMAT(report_date, '%Y-%m') AS mes, AVG(stress_score) as promedio")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // 6. Horas de sueño promedio
        $sleepAvg = DB::table('state_reports')
            ->selectRaw("DATE_FORMAT(report_date, '%Y-%m') AS mes, AVG(sleep_hours) as promedio")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // 7. Respuestas por cuestionario
$questionnaires = DB::table('questionnaire_responses')
    ->join('questionnaires', 'questionnaires.id', '=', 'questionnaire_responses.questionnaire_id')
    ->select('questionnaires.title', DB::raw('COUNT(questionnaire_responses.id) as total'))
    ->groupBy('questionnaires.title')
    ->get();


        // 8. Alertas chatbot
        $alerts = DB::table('chatbot_alerts')
            ->select('alert_type', DB::raw('COUNT(*) as total'))
            ->groupBy('alert_type')
            ->get();

        // 9. Citas por estado
        $appointments = DB::table('appointments')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // 10. Posts por mes
$posts = DB::table('posts')
    ->selectRaw("DATE_FORMAT(created_at, '%b %Y') AS mes, COUNT(*) as total")
    ->groupBy('mes')
    ->orderByRaw("MIN(created_at)")
    ->get();

        // 11. Comentarios por post
        $comments = DB::table('comments')
            ->join('posts', 'posts.id', '=', 'comments.post_id')
            ->select('posts.title', DB::raw('COUNT(comments.id) as total'))
            ->groupBy('posts.title')
            ->get();

        // 12. Recursos por tipo
        $resources = DB::table('resources')
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')->get();

        // 13. Notificaciones leídas/no leídas
        $notifications = DB::table('notifications')
            ->select('is_read', DB::raw('COUNT(*) as total'))
            ->groupBy('is_read')
            ->get();

        // 14. Usuarios activos vs inactivos
        $activeUsers = DB::table('users')
            ->select('is_active', DB::raw('COUNT(*) as total'))
            ->groupBy('is_active')
            ->get();

        // 15. Reportes por estudiante
$reportsPerStudent = DB::table('state_reports')
    ->join('student_profiles', 'student_profiles.id', '=', 'state_reports.student_profile_id')
    ->join('users', 'users.id', '=', 'student_profiles.user_id')
    ->select(
        DB::raw("CONCAT(users.name, ' ', users.paternal_surname, ' ', users.maternal_surname) AS student_name"),
        DB::raw('COUNT(state_reports.id) AS total')
    )
    ->groupBy('student_name')
    ->get();


        return view('admin.dashboard', compact(
            'usersByMonth',
            'roles',
            'professions',
            'moods',
            'stressMonth',
            'sleepAvg',
            'questionnaires',
            'alerts',
            'appointments',
            'posts',
            'comments',
            'resources',
            'notifications',
            'activeUsers',
            'reportsPerStudent'
        ));

    }
}
