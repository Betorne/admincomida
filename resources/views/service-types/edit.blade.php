@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Tipo de Servicio</h1>

<form action="{{ route('service-types.update', $serviceType) }}" method="POST" class="space-y-4 max-w-xl">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="block font-medium">Nombre del servicio</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $serviceType->name) }}"
               class="border border-gray-300 rounded px-4 py-2 w-full" required>
    </div>

    <div>
        <label for="start_time" class="block font-medium">Hora de inicio</label>
        <input type="time" name="start_time" id="start_time"
               value="{{ old('start_time', $serviceType->start_time) }}"
               class="border border-gray-300 rounded px-4 py-2 w-full" required>
    </div>

    <div>
        <label for="end_time" class="block font-medium">Hora de fin</label>
        <input type="time" name="end_time" id="end_time"
               value="{{ old('end_time', $serviceType->end_time) }}"
               class="border border-gray-300 rounded px-4 py-2 w-full" required>
    </div>

    <div class="flex items-center space-x-2">
            <input type="hidden" name="auto_activate" value="0">
            <input type="checkbox" name="auto_activate" id="auto_activate" value="1"
            {{ $serviceType->auto_activate ? 'checked' : '' }}>
        <label for="auto_activate">Activar automáticamente según horario</label>
    </div>

    <div class="flex items-center space-x-2">
        <input type="hidden" name="active" value="0">
        <input type="checkbox" name="active" id="active" value="1"
        {{ $serviceType->active ? 'checked' : '' }}>
        <label for="active">Activar manualmente ahora</label>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('service-types.index') }}" class="text-gray-600 hover:underline">← Volver</a>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar Cambios
        </button>
    </div>
</form>
@endsection
