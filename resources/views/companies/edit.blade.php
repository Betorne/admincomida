@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Editar Empresa</h1>

    <form action="{{ route('companies.update', $company) }}" method="POST" class="space-y-4 max-w-xl">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium">Nombre de la empresa</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $company->name) }}"
                   class="border border-gray-300 rounded px-4 py-2 w-full" required>
        </div>

        <div>
            <label for="rut" class="block font-medium">RUT</label>
            <input type="text" name="rut" id="rut"
                   value="{{ old('rut', $company->rut) }}"
                   class="border border-gray-300 rounded px-4 py-2 w-full" required>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('companies.index') }}" class="text-gray-600 hover:underline">← Volver</a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar Cambios
            </button>
        </div>
    </form>
@endsection
