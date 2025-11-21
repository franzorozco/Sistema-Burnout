<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Usuarios</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding:6px; text-align:left; }
        th { background:#f0f0f0; }
        h2 { text-align:center; }
    </style>
</head>
<body>
    <h2>Reporte de Usuarios</h2>
    <p>Generado: {{ now()->format('Y-m-d H:i') }}</p>
    @if(!empty($filters))
        <p><strong>Filtros aplicados:</strong>
        @foreach($filters as $k => $v)
            @if($v !== null && $v !== '')
                @if($k === 'is_active')
                    {{ $k }}: {{ $v === '1' ? 'Sí' : 'No' }};
                @else
                    {{ $k }}: {{ $v }};
                @endif
            @endif
        @endforeach
        </p>
    @endif
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Activo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $idx => $user)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->paternal_surname }}</td>
                    <td>{{ $user->maternal_surname }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->is_active ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>