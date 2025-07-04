
@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-6">📊 Reportes de Comidas</h1>

  {{-- FILTROS --}}
  <form method="GET" action="{{ route('reports.index') }}" class="bg-white p-6 rounded shadow mb-8 max-w-3xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label for="start_date" class="block mb-1 font-medium">Fecha inicio</label>
        <input type="date" name="start_date" id="start_date"
               value="{{ $filter['start_date'] ?? '' }}"
               class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label for="end_date" class="block mb-1 font-medium">Fecha fin</label>
        <input type="date" name="end_date" id="end_date"
               value="{{ $filter['end_date'] ?? '' }}"
               class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label for="company_id" class="block mb-1 font-medium">Empresa</label>
        <select name="company_id" id="company_id"
                class="w-full border rounded px-3 py-2">
          <option value="">— Todas —</option>
          @foreach($companies as $company)
            <option value="{{ $company->id }}"
              {{ (string)($filter['company_id'] ?? '') === (string)$company->id ? 'selected' : '' }}>
              {{ $company->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="mt-4 text-right">
      <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Filtrar
      </button>
    </div>
  </form>
{{-- Resumen de cantidades por servicio --}}
@if(!empty($summary) && $summary->isNotEmpty())
  <div class="bg-white p-4 rounded shadow mb-6 max-w-3xl mx-auto">
    <h3 class="text-lg font-semibold mb-2">Resumen de Cantidades por Servicio</h3>
    <ul class="list-disc list-inside">
      @foreach($summary as $serviceName => $count)
        <li><strong>{{ $serviceName }}:</strong> {{ $count }}</li>
      @endforeach
    </ul>
  </div>
@endif


<div class="flex justify-end items-center space-x-2 mb-4 max-w-3xl mx-auto">
  <!-- Mantén los filtros del formulario actual -->
  <a href="{{ route('reports.export.excel', request()->query()) }}"
     class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Exportar Excel
  </a>
  <a href="{{ route('reports.export.pdf', request()->query()) }}"
     class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
    Exportar PDF
  </a>
</div>
  {{-- RESULTADOS AGRUPADOS POR SERVICIO --}}
  <div class="space-y-8 max-w-4xl mx-auto">
    @forelse($reports as $serviceName => $group)
      <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">{{ $serviceName }} 
          <span class="text-gray-500">({{ $group->count() }} registros)</span>
        </h2>

        <table class="w-full table-auto border-collapse">
          <thead>
            <tr class="bg-gray-100">
              <th class="border px-4 py-2 text-left">Fecha y Hora</th>
              <th class="border px-4 py-2 text-left">Trabajador</th>
              <th class="border px-4 py-2 text-left">Empresa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($group as $record)
              <tr>
                <td class="border px-4 py-2">{{ $record->registered_at->format('Y-m-d H:i') }}</td>
                <td class="border px-4 py-2">{{ $record->worker->name }}</td>
                <td class="border px-4 py-2">{{ $record->worker->company->name }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @empty
      <div class="text-center text-gray-600">No se encontraron registros para esos filtros.</div>
    @endforelse
  </div>
@endsection
