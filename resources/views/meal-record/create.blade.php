@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Registro de comida (OCR Automático)</h1>

    {{-- Selector de cámara --}}
    <div class="mb-4 max-w-md mx-auto">
        <label for="cameraSelect" class="block font-medium mb-1">Elige cámara:</label>
        <select id="cameraSelect" class="border px-4 py-2 w-full"></select>
    </div>

    {{-- Video + guía de posicionamiento --}}
    <div class="relative mb-4 max-w-md mx-auto">
        <video id="video" class="w-full rounded border" autoplay muted playsinline></video>
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
            <label for="rut" class="block font-medium">RUT detectado:</label>
            <input type="text" id="rut" name="rut"
                   class="border px-4 py-2 w-full"  required>
        </div>

        {{-- Tipo de servicio activo… (igual que antes) --}}
        {{-- … --}}

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
            Registrar comida
        </button>
    </form>

    <canvas id="canvas" class="hidden"></canvas>
    <script src="https://unpkg.com/tesseract.js@v4.0.2/dist/tesseract.min.js"></script>

    <script>
    (async function() {
        const video        = document.getElementById('video');
        const cameraSelect = document.getElementById('cameraSelect');
        let currentStream  = null;

        // 1. Enumerar dispositivos y llenar el select
        async function getCameras() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoInputs = devices.filter(d => d.kind === 'videoinput');
            cameraSelect.innerHTML = '';
            videoInputs.forEach((device, idx) => {
                const label = device.label || `Cámara ${idx+1}`;
                const opt = document.createElement('option');
                opt.value = device.deviceId;
                opt.text  = label;
                cameraSelect.appendChild(opt);
            });
        }

        // 2. Iniciar el stream con el deviceId seleccionado
        async function startStream() {
            if (currentStream) {
                currentStream.getTracks().forEach(t => t.stop());
            }
            const deviceId = cameraSelect.value;
            const constraints = {
                video: { 
                    deviceId: deviceId ? { exact: deviceId } : undefined,
                    facingMode: "environment"
                }
            };
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                currentStream = stream;
                video.srcObject  = stream;
            } catch (err) {
                document.getElementById('status').textContent = 'Error cámara: ' + err.message;
            }
        }

        // 3. Al cambiar de cámara, reiniciar stream
        cameraSelect.onchange = startStream;

        // 4. Poblamos cámaras y arrancamos
        await getCameras();
        await startStream();

        // 5. Preparar OCR
        const canvas = document.getElementById('canvas');
        const status = document.getElementById('status');
        const rutInput = document.getElementById('rut');
        const worker = Tesseract.createWorker({ logger: ()=>{} });
        await worker.load();
        await worker.loadLanguage('spa');
        await worker.initialize('spa');

        // 6. Escaneo periódico
        let scanning = false;
        async function captureAndOcr() {
            if (scanning || rutInput.value) return;
            scanning = true;
            status.textContent = 'Procesando OCR...';

            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            const { data:{ text } } = await worker.recognize(canvas);
            const match = text.match(/(\d{1,2}\.?\d{3}\.?\d{3}-[\dkK])/);
            if (match) {
                rutInput.value = match[1].replace(/\./g,'');
                status.textContent = 'RUT detectado: ' + rutInput.value;
                clearInterval(interval);
            } else {
                status.textContent = 'Buscando RUN...';
            }
            scanning = false;
        }
        const interval = setInterval(captureAndOcr, 3000);
    })();
    </script>
@endsection
