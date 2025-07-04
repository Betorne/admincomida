{{-- resources/views/reports/pdf.blade.php --}}
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h2 { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th,td { border: 1px solid #333; padding: 4px; }
    th { background: #eee; }
  </style>
</head>
<body>
  <h2>Reporte de Comidas</h2>
  <table>
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Trabajador</th>
        <th>Empresa</th>
        <th>Servicio</th>
      </tr>
    </thead>
    <tbody>
      @foreach($records as $r)
        <tr>
          <td>{{ \Carbon\Carbon::parse($r->registered_at)->format('Y-m-d H:i') }}</td>
          <td>{{ $r->worker->name }}</td>
          <td>{{ $r->worker->company->name }}</td>
          <td>{{ $r->serviceType->name }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
   {{-- Bloque de resumen --}}
  <div class="summary">
    <h3>Resumen de Cantidades por Servicio</h3>
    <ul>
      @foreach($records->groupBy(fn($r) => $r->serviceType->name) as $serviceName => $group)
        <li><strong>{{ $serviceName }}:</strong> {{ $group->count() }} registros</li>
      @endforeach
    </ul>
  </div>
</body>
</html>
