@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tipos de Servicio</h1>

<a href="{{ route('service-types.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">Agregar nuevo tipo</a>
@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<table class="min-w-full bg-white border">
    <thead>
        <tr>
            <th class="border px-4 py-2">Nombre</th>
            <th class="border px-4 py-2">Hora inicio</th>
            <th class="border px-4 py-2">Hora fin</th>
            <th class="border px-4 py-2">Activo</th>
            <th class="border px-4 py-2">Autoactivar</th>
            <th class="border px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
            <tr>
                <td class="border px-4 py-2">{{ $service->name }}</td>
                <td class="border px-4 py-2">{{ $service->start_time }}</td>
                <td class="border px-4 py-2">{{ $service->end_time }}</td>
                <td class="border px-4 py-2">
                    @if($service->active)
                        <span class="text-green-600 font-semibold">Sí</span>
                    @else
                        <span class="text-red-600">No</span>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    {{ $service->auto_activate ? 'Sí' : 'No' }}
                </td>
                <td class="border px-4 py-2">
<a href="{{ route('service-types.edit', $service->id) }}" class="text-blue-600 hover:underline">Editar</a>
                    |
                    <form action="{{ route('service-types.destroy', $service) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar este tipo de servicio?')" class="text-red-600">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
