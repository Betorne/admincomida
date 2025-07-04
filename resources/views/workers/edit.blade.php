@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-10">
  <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Editar Trabajador</h1>

    <form action="{{ route('workers.update', $worker) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $worker->name) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3"
               required>
      </div>

      <div>
        <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">RUT</label>
        <input type="text" name="rut" id="rut"
               value="{{ old('rut', $worker->rut) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3"
               required>
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email"
               value="{{ old('email', $worker->email) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
      </div>

      <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
        <input type="text" name="phone" id="phone"
               value="{{ old('phone', $worker->phone) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
      </div>

      <div>
        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
        <select name="company_id" id="company_id"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
          @foreach($companies as $company)
            <option value="{{ $company->id }}" @if($worker->company_id == $company->id) selected @endif>
              {{ $company->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="text-center">
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-md shadow hover:bg-blue-700 transition">
          Guardar Cambios
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
