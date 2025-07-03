@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Registro de comida (OCR Automático)</h1>

    {{-- Video + guía de posicionamiento --}}
    <div class="relative mb-4 max-w-md mx-auto">
        <video id="video" class="w-full rounded border" autoplay ></video>
        {{-- Rectángulo guía --}}
        <div id="guide"
             class="absolute border-4 border-yellow-400 rounded"
             style="top: 30%; left: 15%; width: 70%; height: 40%; pointer-events: none;">
        </div>
    </div>

    <div class="mb-4">
        <span id="status" class="text-gray-600"></span>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('meal.store') }}" method="POST" class="space-y-4 max-w-md mx-auto">
        @csrf
        <input type="hidden" name="worker_id" id="worker_id">

        <div>
            <label for="rut" class="border px-4 py-2 w-full">RUT detectado:</label>
            <input type="text" id="rut" name="rut"
                   class="border px-4 py-2 w-full"  required>
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
            Registrar comida
        </button>
    </form>

    {{-- Canvas oculto para OCR --}}
    <canvas id="canvas" class="hidden"></canvas>

    {{-- Tesseract.js --}}
    <script src="https://unpkg.com/tesseract.js@v4.0.2/dist/tesseract.min.js"></script>

    <script>
    (async function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const status = document.getElementById('status');
        const rutInput = document.getElementById('rut');
        let scanning = false;

        // Pedir acceso a cámara
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (err) {
            status.textContent = 'No se pudo acceder a la cámara: ' + err.message;
            return;
        }

        // Función de captura y OCR
        async function captureAndOcr() {
            if (scanning || rutInput.value) return;
            scanning = true;
            status.textContent = 'Procesando imagen...';

            // Captura TODO el video, pero el usuario alinea el RUN dentro del rectángulo guía
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            try {
                const { data: { text } } = await Tesseract.recognize(canvas, 'spa', {
                    logger: m => console.log(m)
                });
                const match = text.match(/(\d{1,2}\.?\d{3}\.?\d{3}-[\dkK])/);
                if (match) {

                    
                    rutInput.value = match[1];


                    
                    status.textContent = 'RUT detectado: ' + match[1];
                    clearInterval(scannerInterval);
                } else {
                    status.textContent = 'Buscando RUT...';
                }
            } catch (e) {
                console.error(e);
                status.textContent = 'Error OCR, reintentando...';
            } finally {
                scanning = false;
            }
        }

        // Escanear cada 3 segundos
        const scannerInterval = setInterval(captureAndOcr, 3000);
    })();
    </script>
@endsection
