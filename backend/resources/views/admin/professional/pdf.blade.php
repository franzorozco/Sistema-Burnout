<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Profesionales</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding:6px; text-align:left; }
        th { background:#f0f0f0; }
        h2 { text-align:center; }
    </style>
</head>
<body>
    <h2>Reporte de Profesionales</h2>
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
                <th>Profesión</th>
                <th>Licencia</th>
                <th>Biografía</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professionals as $idx => $p)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $p->user_id }}</td>
                    <td>{{ $p->profession }}</td>
                    <td>{{ $p->license_number }}</td>
                    <td>{{ $p->bio }}</td>
                    <td>{{ $p->is_available ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
