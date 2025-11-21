<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f5f7fb !important;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-title {
            font-weight: 700;
            font-size: 28px;
            color: #333;
        }

        .dashboard-subtitle {
            color: #666;
            font-size: 14px;
        }

        .card {
            border-radius: 14px !important;
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.12) !important;
        }

        .card-title {
            font-weight: 600;
        }

        .chart-icon {
            font-size: 22px;
            float: right;
            opacity: 0.7;
        }

        .divider {
            width: 100%;
            height: 1px;
            background: #e1e4ea;
            margin: 20px 0;
        }

        /* ----------------------
           NUEVO ESTILO GRÁFICOS
        ---------------------- */
        .chart-container {
            height: 250px; /* altura uniforme */
            width: 100%;
        }

        .card-body {
            padding: 1rem;
        }
    </style>

</head>
<body>

@include('layouts.partials.admin.navigation')
@include('layouts.partials.admin.sidebar')

<div class="p-4 sm:ml-64">
    <div class="mt-5">

        <!-- Título del Dashboard -->
        <div>
            <h2 class="dashboard-title">Panel de Análisis</h2>
            <p class="dashboard-subtitle">Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="divider"></div>

        @yield('content')

        <!-- ==========================
              GRID DE GRÁFICOS
        ========================== -->
        <div class="row g-3 mt-3">

            <!-- Profesiones -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-briefcase chart-icon"></i>
                        <h5 class="card-title mb-3">Profesiones de Profesionales</h5>
                        <p class="text-muted small">Total: {{ $professions->sum('total') }}</p>
                        <div class="chart-container">
                            <canvas id="profChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado de Ánimo -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-face-smile chart-icon"></i>
                        <h5 class="card-title mb-3">Estado de Ánimo</h5>
                        <p class="text-muted small">Total: {{ $moods->sum('total') }}</p>
                        <div class="chart-container">
                            <canvas id="moodChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estrés Promedio -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-heartbeat chart-icon"></i>
                        <h5 class="card-title mb-3">Estrés Promedio por Mes</h5>
                        <div class="chart-container">
                            <canvas id="stressMonth"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horas de Sueño -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-moon chart-icon"></i>
                        <h5 class="card-title mb-3">Horas de Sueño Promedio</h5>
                        <div class="chart-container">
                            <canvas id="sleepChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cuestionarios -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-clipboard-question chart-icon"></i>
                        <h5 class="card-title mb-3">Respuestas por Cuestionario</h5>
                        <div class="chart-container">
                            <canvas id="questChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-triangle-exclamation chart-icon"></i>
                        <h5 class="card-title mb-3">Alertas Detectadas</h5>
                        <div class="chart-container">
                            <canvas id="alertsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Citas -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-calendar-check chart-icon"></i>
                        <h5 class="card-title mb-3">Citas por Estado</h5>
                        <div class="chart-container">
                            <canvas id="appointmentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-pen-to-square chart-icon"></i>
                        <h5 class="card-title mb-3">Posts por Mes</h5>
                        <div class="chart-container">
                            <canvas id="postsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comentarios -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-comments chart-icon"></i>
                        <h5 class="card-title mb-3">Comentarios por Post</h5>
                        <div class="chart-container">
                            <canvas id="commentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios Activos -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-user-check chart-icon"></i>
                        <h5 class="card-title mb-3">Usuarios Activos / Inactivos</h5>
                        <div class="chart-container">
                            <canvas id="activeUsersChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reportes por Estudiante -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="fa fa-chart-simple chart-icon"></i>
                        <h5 class="card-title mb-3">Reportes por Estudiante</h5>
                        <div class="chart-container">
                            <canvas id="reportsStudentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- row -->

    </div>
</div>

<!-- ================================
     SCRIPTS
================================ -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/2b2c42c507.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ================================
     SCRIPTS DE LOS GRÁFICOS
================================ -->
<script>
/* ---- PROFESIONES ---- */
new Chart(document.getElementById('profChart'), {
    type: 'pie',
    data: {
        labels: @json($professions->pluck('profession')),
        datasets: [{ data: @json($professions->pluck('total')) }]
    }
});

/* ---- ESTADO DE ÁNIMO ---- */
new Chart(document.getElementById('moodChart'), {
    type: 'doughnut',
    data: {
        labels: @json($moods->pluck('mood')),
        datasets: [{ data: @json($moods->pluck('total')) }]
    }
});

/* ---- ESTRÉS ---- */
new Chart(document.getElementById('stressMonth'), {
    type: 'line',
    data: {
        labels: @json($stressMonth->pluck('mes')),
        datasets: [{ label: 'Estrés promedio', data: @json($stressMonth->pluck('promedio')), borderWidth: 2 }]
    }
});

/* ---- SUEÑO ---- */
new Chart(document.getElementById('sleepChart'), {
    type: 'bar',
    data: {
        labels: @json($sleepAvg->pluck('mes')),
        datasets: [{ label: 'Horas de sueño', data: @json($sleepAvg->pluck('promedio')) }]
    }
});

/* ---- CUESTIONARIOS ---- */
new Chart(document.getElementById('questChart'), {
    type: 'bar',
    data: {
        labels: @json($questionnaires->pluck('title')),
        datasets: [{ label: 'Respuestas por Cuestionario', data: @json($questionnaires->pluck('total')) }]
    }
});

/* ---- ALERTAS ---- */
new Chart(document.getElementById('alertsChart'), {
    type: 'pie',
    data: {
        labels: @json($alerts->pluck('alert_type')),
        datasets: [{ data: @json($alerts->pluck('total')) }]
    }
});

/* ---- CITAS ---- */
new Chart(document.getElementById('appointmentsChart'), {
    type: 'bar',
    data: {
        labels: @json($appointments->pluck('status')),
        datasets: [{ label: 'Citas', data: @json($appointments->pluck('total')) }]
    }
});

/* ---- POSTS ---- */
new Chart(document.getElementById('postsChart'), {
    type: 'line',
    data: {
        labels: @json($posts->pluck('mes')),
        datasets: [{ label: 'Posts creados', data: @json($posts->pluck('total')) }]
    }
});

/* ---- COMENTARIOS ---- */
new Chart(document.getElementById('commentsChart'), {
    type: 'bar',
    data: {
        labels: @json($comments->pluck('title')),
        datasets: [{ label: 'Comentarios', data: @json($comments->pluck('total')) }]
    }
});

/* ---- USUARIOS ACTIVOS ---- */
new Chart(document.getElementById('activeUsersChart'), {
    type: 'bar',
    data: {
        labels: ['Inactivos', 'Activos'],
        datasets: [{ data: @json($activeUsers->pluck('total')) }]
    }
});

/* ---- REPORTES POR ESTUDIANTE ---- */
new Chart(document.getElementById('reportsStudentChart'), {
    type: 'bar',
    data: {
        labels: @json($reportsPerStudent->pluck('student_name')),
        datasets: [{ label: 'Reportes', data: @json($reportsPerStudent->pluck('total')) }]
    }
});
</script>

</body>
</html>
