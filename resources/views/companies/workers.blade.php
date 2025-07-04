@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">
    Trabajadores de {{ $company->name }}
  </h1>

  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
    <div class="flex space-x-2">
      <a href="{{ route('workers.create') }}?company_id={{ $company->id }}"
         class="bg-blue-500 text-white px-4 py-2 rounded">
        Agregar trabajador
      </a>
      <a href="{{ route('companies.index') }}"
         class="ml-2 text-gray-600 hover:underline">
        ← Volver a Empresas
      </a>
    </div>

    <form method="GET" action="{{ route('companies.workers', $company) }}" class="flex mt-2 md:mt-0">
      <input type="text"
             name="search"
             value="{{ request('search') }}"
             placeholder="Buscar por nombre, RUT, email o teléfono…"
             class="border rounded-l px-3 py-2 w-full md:w-64 focus:outline-none">
      <button type="submit"
              class="bg-green-600 text-white px-4 py-2 rounded-r hover:bg-green-700">
        Buscar
      </button>
    </form>
  </div>

  @if(request('search'))
    <div class="mb-4 text-gray-700">
      Resultados para: <strong>{{ request('search') }}</strong>
    </div>
  @endif

  @if($workers->isEmpty())
    <div class="mt-6 text-gray-600">No hay trabajadores que coincidan.</div>
  @else
    <table class="min-w-full bg-white border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">Nombre</th>
          <th class="border px-4 py-2">RUT</th>
          <th class="border px-4 py-2">Email</th>
          <th class="border px-4 py-2">Teléfono</th>
          <th class="border px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($workers as $worker)
          <tr>
            <td class="border px-4 py-2">{{ $worker->name }}</td>
            <td class="border px-4 py-2">{{ $worker->rut }}</td>
            <td class="border px-4 py-2">{{ $worker->email }}</td>
            <td class="border px-4 py-2">{{ $worker->phone }}</td>
            <td class="border px-4 py-2">
              <a href="{{ route('workers.edit', $worker) }}" class="text-blue-600">Editar</a>
              |
              <form action="{{ route('workers.destroy', $worker) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar este trabajador?')" class="text-red-600">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  

    <div class="mt-4">
    {{ $workers->links() }}
    </div>

  @endif
@endsection
