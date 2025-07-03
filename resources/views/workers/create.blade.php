@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Agregar trabajador</h1>

<form action="{{ route('workers.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block">Nombre:</label>
        <input type="text" name="name" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">RUT:</label>
        <input type="text" name="rut" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">Email:</label>
        <input type="email" name="email" class="border p-2 w-full">
    </div>

    <div>
        <label class="block">Dirección:</label>
        <input type="text" name="address" class="border p-2 w-full">
    </div>

    <div>
        <label class="block">Teléfono:</label>
        <input type="text" name="phone" class="border p-2 w-full">
    </div>

    <div>
        <label class="block">Empresa:</label>
        <select name="company_id" class="border p-2 w-full">
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    </div>
</form>
@endsection
