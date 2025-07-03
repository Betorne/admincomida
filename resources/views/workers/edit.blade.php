@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Editar trabajador</h1>

<form action="{{ route('workers.update', $worker) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block">Nombre:</label>
        <input type="text" name="name" value="{{ old('name', $worker->name) }}" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">RUT:</label>
        <input type="text" name="rut" value="{{ old('rut', $worker->rut) }}" class="border p-2 w-full" required>
    </div>

    <div>
        <label class="block">Email:</label>
        <input type="email" name="email" value="{{ old('email', $worker->email) }}" class="border p-2 w-full">
    </div>

    <div>
        <label class="block">Teléfono:</label>
        <input type="text" name="phone" value="{{ old('phone', $worker->phone) }}" class="border p-2 w-full">
    </div>

    <div>
        <label class="block">Empresa:</label>
        <select name="company_id" class="border p-2 w-full">
            @foreach($companies as $company)
                <option value="{{ $company->id }}" @if($worker->company_id == $company->id) selected @endif>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar cambios</button>
</form>
@endsection
