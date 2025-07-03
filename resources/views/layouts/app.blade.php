<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Colaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Flowbite -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />

</head>
<body class="bg-gray-100 text-gray-900">
    @include('layouts.navbar')
    <div class="min-h-screen p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold">Sistema de Comidas</h1>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
@section('scripts')
    <!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabla-trabajadores').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.getElementById('nfcButton').addEventListener('click', async () => {
    const status = document.getElementById('nfcStatus');

    if (!('NDEFReader' in window)) {
        status.textContent = "NFC no compatible con este navegador.";
        return;
    }

    try {
        const ndef = new NDEFReader();
        await ndef.scan();

        status.textContent = "Acerque su carnet al lector NFC...";

        ndef.onreading = event => {
            const message = event.message;
            for (const record of message.records) {
                if (record.recordType === "text") {
                    const textDecoder = new TextDecoder(record.encoding);
                    const rut = textDecoder.decode(record.data);
                    document.getElementById('rut').value = rut;
                    status.textContent = "RUT leído: " + rut;
                }
            }
        };

        ndef.onreadingerror = () => {
            status.textContent = "Error al leer la tarjeta NFC.";
        };
    } catch (error) {
        status.textContent = "Error: " + error;
    }
});
</script>

@endsection
    </div>

    @yield('scripts')



</body>
</html>
