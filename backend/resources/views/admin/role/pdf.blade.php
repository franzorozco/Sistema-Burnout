<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Roles</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding:6px; text-align:left; }
        th { background:#f0f0f0; }
        h2 { text-align:center; }
    </style>
</head>
<body>
    <h2>Reporte de Roles</h2>
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
                <th>Nombre</th>
                <th>Guard</th>
                <th>Descripción</th>
                <th>Creado Por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $idx => $r)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->guard_name }}</td>
                    <td>{{ $r->description }}</td>
                    <td>{{ $r->created_by }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
