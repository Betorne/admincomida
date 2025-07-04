<!-- resources/views/layouts/navbar.blade.php -->
<nav class="bg-gray-800 text-white px-6 py-3 shadow-md">
    <div class="flex justify-between items-center">
        <div class="text-xl font-bold">Sistema de Colaciones</div>

        <ul class="flex space-x-6 text-sm">
            <li>
                <a href="{{ route('companies.index') }}" class="hover:text-yellow-400">Empresas</a>
            </li>
            <li>
                <a href="{{ route('workers.index') }}" class="hover:text-yellow-400">Trabajadores</a>
            </li>
       
            <li>
                <a href="{{ route('service-types.index') }}" class="hover:text-yellow-400">Tipos de Servicio</a>
            </li>
            <li>
                <a href="{{ route('meal.create') }}" class="hover:text-yellow-400">Registro de Comida</a>
            </li>
             <!-- Nuevo enlace a Reportes -->
                <li>
        <a href="{{ route('reports.index') }}"
           class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
          Reportes
        </a>
        </li>
        </ul>
    </div>
</nav>
