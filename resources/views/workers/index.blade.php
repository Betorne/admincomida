@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Listado de trabajadores</h1>

    <a href="{{ route('workers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Agregar trabajador</a>


    <table id="tabla-trabajadores" class="min-w-full divide-y divide-gray-200 shadow rounded-lg">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">RUT</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Empresa</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($workers as $worker)
        <tr>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $worker->name }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $worker->rut }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $worker->email }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $worker->phone }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $worker->company->name ?? 'Sin empresa' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('workers.edit', $worker) }}"
                   class="text-blue-600 hover:underline">Editar</a>
                <form action="{{ route('workers.destroy', $worker) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline"
                            onclick="return confirm('¿Eliminar este trabajador?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



   
    <h2 class="text-xl font-bold mt-8 mb-2">Importar trabajadores desde CSV</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('workers.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <input type="file" name="file" accept=".csv" class="border p-2 w-full" required>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Importar</button>
</form>
@endsection
