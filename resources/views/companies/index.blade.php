@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Listado de Empresas</h1>

<a href="{{ route('companies.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Agregar empresa</a>

<table class="min-w-full bg-white border">
    <thead>
        <tr>
            <th class="border px-4 py-2">Nombre</th>
            <th class="border px-4 py-2">RUT</th>
            <th class="border px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td class="border px-4 py-2">{{ $company->name }}</td>
                <td class="border px-4 py-2">{{ $company->rut }}</td>
                <td class="border px-4 py-2">
                   <td class="border px-4 py-2">
                        <a href="{{ route('companies.edit', $company) }}" class="text-blue-600">Editar</a>
                        |
                        <a href="{{ route('companies.workers', $company) }}" class="ml-2 text-green-600">Ver trabajadores</a>
                        |
                        <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Eliminar esta empresa?')"
                                    class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
