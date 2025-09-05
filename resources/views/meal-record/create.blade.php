@extends('layouts.app')

@section('content')
    
    {{-- Formulario --}}
<form id="meal-form" action="{{ route('meal.store') }}" method="POST" class="space-y-4 max-w-md mx-auto">
        @csrf
        <input type="hidden" name="worker_id" id="worker_id"  >

        <div>
            <label for="rut" class="block font-medium">RUT detectado:</label>
                    @error('rut') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

<input
  type="text"
  id="rut"
  name="rut"
  class="border px-4 py-2 w-full"
  placeholder="12345678-9"
  pattern="^\d{5,8}-[0-9K]$"
  inputmode="text"
  autocomplete="off"
  autofocus
  required
/>
        </div>

        {{-- Tipo de servicio --}}
   {{-- Tipo de servicio (radios como botones) --}}
@if($services->count() > 1)
  @php
    $selected = old('service_type_id', optional($services->first())->id);
  @endphp

  <fieldset>
    <legend class="block font-medium mb-2">Tipo de servicio:</legend>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
      @foreach($services as $srv)
        @php $rid = 'srv_'.$srv->id; @endphp

        <div class="relative">
          <input
            type="radio"
            name="service_type_id"
            id="{{ $rid }}"
            value="{{ $srv->id }}"
            class="peer sr-only"
            {{ (string)$selected === (string)$srv->id ? 'checked' : '' }}
            {{ $loop->first ? 'required' : '' }}
          >
          <label for="{{ $rid }}"
                 class="block border rounded px-4 py-3 cursor-pointer text-center
                        hover:border-green-600
                        peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600">
            <span class="font-medium">{{ $srv->name }}</span>
            <span class="block text-sm text-gray-600 peer-checked:text-white">
              {{ $srv->start_time }}–{{ $srv->end_time }}
            </span>
          </label>
        </div>
      @endforeach
    </div>
  </fieldset>

@elseif($services->count() === 1)
  @php $srv = $services->first(); $rid = 'srv_'.$srv->id; @endphp
  <fieldset>
    <legend class="block font-medium mb-2">Tipo de servicio:</legend>
    <div class="grid grid-cols-1 gap-2">
      <div class="relative">
        <input type="radio" name="service_type_id" id="{{ $rid }}" value="{{ $srv->id }}" class="peer sr-only" checked required>
        <label for="{{ $rid }}"
               class="block border rounded px-4 py-3 cursor-pointer text-center
                      peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600">
          <span class="font-medium">{{ $srv->name }}</span>
          <span class="block text-sm text-gray-600 peer-checked:text-white">
            {{ $srv->start_time }}–{{ $srv->end_time }}
          </span>
        </label>
      </div>
    </div>
  </fieldset>

@else
  <div class="text-red-600">No hay servicios activos.</div>
@endif


        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
            Registrar comida
        </button>
    </form>
 {{-- ÚLTIMOS 10 REGISTROS --}}
  <div class="mt-8 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Últimos 3 registros</h2>
    <div class="overflow-x-auto">
      <table class="w-full bg-white border">
        <thead>
          <tr class="bg-gray-100">
            <th class="border px-4 py-2">Fecha y Hora</th>
            <th class="border px-4 py-2">Trabajador</th>
            <th class="border px-4 py-2">Empresa</th>
            <th class="border px-4 py-2">Servicio</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recent as $rec)
            <tr>
              <td class="border px-4 py-2">{{ $rec->registered_at->format('Y-m-d H:i') }}</td>
              <td class="border px-4 py-2">{{ $rec->worker->name }}</td>
              <td class="border px-4 py-2">{{ $rec->worker->company->name }}</td>
              <td class="border px-4 py-2">{{ $rec->serviceType->name }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="border px-4 py-4 text-center text-gray-600">
                No hay registros aún.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
    <canvas id="canvas" class="hidden"></canvas>
    <script src="https://unpkg.com/tesseract.js@v4.0.2/dist/tesseract.min.js"></script>
<script>
(() => {
  const $rut  = document.getElementById('rut');
  const $form = document.getElementById('meal-form');

  // --- Extracción estricta
  function extractRun(s) {
    const str = String(s || '');

    // 1) Prioriza token justo después de RUN y antes del siguiente "/"
    const mRun = str.match(/RUN(?:[=¿:._\- ]+)?([^\/\s]+)(?=\/|$)/i);
    if (mRun) return mRun[1];

    // 2) Si aparece MRZ en el texto, no usamos fallback (evita capturar la cola)
    if (/mrz/i.test(str)) return null;

    // 3) Fallback SOLO si no hay MRZ: 5–8 dígitos + DV (dígito o K)
    const mAny = str.match(/(?<!\d)(\d{5,8})[.’' \-]?([0-9kK])(?!\d)/);
    if (mAny) return mAny[1] + mAny[2];

    return null;
  }

  // --- Normalización y verificación
  function normalizeRun(token) {
    if (!token) return null;
    const clean = token.replace(/[^\dKk]/g, '').toUpperCase();
    if (clean.length < 2) return null;
    const cuerpo = clean.slice(0, -1);
    const dv     = clean.slice(-1);
    if (cuerpo.length < 5 || cuerpo.length > 8) return null;
    return `${cuerpo}-${dv}`;
  }

  function calculaDV(cuerpo) {
    let sum = 0, mul = 2;
    for (let i = cuerpo.length - 1; i >= 0; i--) {
      sum += parseInt(cuerpo[i], 10) * mul;
      mul = (mul === 7) ? 2 : mul + 1;
    }
    const res = 11 - (sum % 11);
    return res === 11 ? '0' : res === 10 ? 'K' : String(res);
  }

  function formatIfPossible(setValidity = true) {
    const candidate = extractRun($rut.value);
    const formatted = normalizeRun(candidate);
    if (!formatted) {
      if (setValidity) $rut.setCustomValidity('RUN no reconocido. Pegue la línea con RUN… o escriba 12345678-9.');
      return false;
    }
    $rut.value = formatted;
    if (setValidity) {
      const [cuerpo, dv] = formatted.split('-');
      const dvCalc = calculaDV(cuerpo);
      $rut.setCustomValidity(dv === dvCalc ? '' : 'RUN inválido (DV no coincide).');
    }
    return true;
  }

  // --- 1) Debounce durante el tipeo del escáner
  let t = null;
  $rut.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(() => formatIfPossible(false), 120); // intenta formatear tras 120ms de inactividad
  });

  // --- 2) Intercepta Enter/Tab antes de la validación del navegador
  $rut.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === 'Tab') {
      const ok = formatIfPossible(true);
      if (!ok) {
        e.preventDefault();
        $rut.reportValidity();
      }
      // si ok y era Enter, dejamos que el submit siga normalmente
    }
  });

  // También en blur y pegado manual
  $rut.addEventListener('blur', () => formatIfPossible(true));
  $rut.addEventListener('paste', () => setTimeout(() => formatIfPossible(true), 0));

  // --- 3) Último seguro antes de enviar
  $form?.addEventListener('submit', (e) => {
    const ok = formatIfPossible(true);
    if (!ok) {
      e.preventDefault();
      $rut.reportValidity();
    }
  });
})();
</script>

  
@endsection