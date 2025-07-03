@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Agregar Tipo de Servicio</h1>

<form action="{{ route('service-types.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block">Nombre:</label>
        <input type="text" name="name" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">Hora de inicio:</label>
        <input type="time" name="start_time" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">Hora de fin:</label>
        <input type="time" name="end_time" class="border p-2 w-full" required>
    </div>

    <div class="flex items-center space-x-2">
        <input type="checkbox" name="auto_activate" id="auto_activate" checked>
        <label for="auto_activate">Activar automáticamente según horario</label>
    </div>

    <div class="flex items-center space-x-2">
        <input type="checkbox" name="active" id="active">
        <label for="active">Activar manualmente ahora</label>
    </div>

    <div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </div>
</form>
@endsection
