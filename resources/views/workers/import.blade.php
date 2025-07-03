@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Importar trabajadores desde CSV</h1>

<form action="{{ route('workers.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
        <label class="block mb-1">Selecciona un archivo CSV:</label>
        <input type="file" name="file" class="border p-2 w-full" accept=".csv" required>
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Importar</button>
    </div>
</form>
@endsection
