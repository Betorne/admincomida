<nav class="bg-white border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      {{-- Logo / Inicio --}}
   

      {{-- Enlaces de autenticación --}}
      <div class="space-x-4">
        @guest
          <a href="{{ route('login') }}"    class="text-gray-600 hover:text-gray-900">Login</a>
          <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
        @else
          
                    
            <ul class="flex space-x-4">
                <li><a href="{{ route('companies.index') }}">Empresas</a></li>
 
                <li><a href="{{ route('workers.index') }}">Trabajadores</a></li>

                <li><a href="{{ route('service-types.index') }}">Tipos de Servicios</a></li>

                <li><a href="{{ route('meal.create') }}">Registro de Servicios</a></li>

                <li><a href="{{ route('reports.index') }}" >Reportes</a></li>
            
           




          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                    class="text-red-600 hover:text-red-800"
                    onclick="return confirm('¿Cerrar sesión?')">
              Logout
            </button>
          </form>
        @endguest
 </ul>
    </div>
    </div>
  </div>
</nav>
