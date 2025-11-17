<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Publicaciones</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding:6px; text-align:left; }
        th { background:#f0f0f0; }
        h2 { text-align:center; }
    </style>
</head>
<body>
    <h2>Reporte de Publicaciones</h2>
    <p>Generado: {{ now()->format('Y-m-d H:i') }}</p>
    @if(!empty($filters))
        <p><strong>Filtros aplicados:</strong>
        @foreach($filters as $k => $v)
            @if($v !== null && $v !== '')
                {{ $k }}: {{ $v }};
            @endif
        @endforeach
        </p>
    @endif
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Título</th>
                <th>Contenido</th>
                <th>Anónimo</th>
                <th>Puntuación</th>
                <th>Vistas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $idx => $p)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $p->user_id }}</td>
                    <td>{{ $p->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($p->body, 100) }}</td>
                    <td>{{ $p->is_anonymous ? 'Sí' : 'No' }}</td>
                    <td>{{ $p->score }}</td>
                    <td>{{ $p->views }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
