@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Agregar Empresa</h1>

<form action="{{ route('companies.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block">Nombre de la empresa:</label>
        <input type="text" name="name" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">RUT de la empresa:</label>
        <input type="text" name="rut" class="border p-2 w-full" required>
    </div>

    <div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
    </div>
</form>
@endsection
