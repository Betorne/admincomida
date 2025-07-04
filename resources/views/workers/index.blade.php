@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Listado de Trabajadores</h1>

  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
    <a href="{{ route('workers.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded mb-2 md:mb-0">
      Agregar trabajador
    </a>

    <form method="GET" action="{{ route('workers.index') }}" class="flex">
      <input type="text"
             name="search"
             value="{{ $search ?? '' }}"
             placeholder="Buscar por nombre, RUT, email, teléfono…"
             class="border rounded-l px-3 py-2 w-full md:w-64 focus:outline-none"
      >
      <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">
        Buscar
      </button>
    </form>
  </div>

  @if(!empty($search))
    <div class="mb-4 text-gray-700">
      Resultados para: <strong>{{ $search }}</strong>
    </div>
  @endif

  <table class="min-w-full bg-white border">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2">Nombre</th>
        <th class="border px-4 py-2">RUT</th>
        <th class="border px-4 py-2">Email</th>
        <th class="border px-4 py-2">Teléfono</th>
        <th class="border px-4 py-2">Empresa</th>
        <th class="border px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($workers as $worker)
        <tr>
          <td class="border px-4 py-2">{{ $worker->name }}</td>
          <td class="border px-4 py-2">{{ $worker->rut }}</td>
          <td class="border px-4 py-2">{{ $worker->email }}</td>
          <td class="border px-4 py-2">{{ $worker->phone }}</td>
          <td class="border px-4 py-2">{{ $worker->company->name }}</td>
          <td class="border px-4 py-2">
            <a href="{{ route('workers.edit', $worker) }}" class="text-blue-600">Editar</a> |
            <form action="{{ route('workers.destroy', $worker) }}"
                  method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit"
                      onclick="return confirm('¿Eliminar este trabajador?')"
                      class="text-red-600">Borrar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="border px-4 py-4 text-center text-gray-600">
            No hay trabajadores que coincidan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $workers->links() }}
  </div>
@endsection
