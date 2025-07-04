<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MealRecordsExport implements FromCollection, WithHeadings
{
    protected Collection $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        // 1) Filas de detalle
        $rows = $this->records->map(fn($r) => [
            $r->registered_at->format('Y-m-d H:i'),
            $r->worker->name,
            $r->worker->company->name,
            $r->serviceType->name,
        ])->toArray();

        // 2) Línea en blanco
        $rows[] = [];

        // 3) Cabecera de resumen
        $rows[] = ['Resumen de Cantidades por Servicio', '', '', ''];

        // 4) Cálculo del resumen
        $summary = $this->records
            ->groupBy(fn($r) => $r->serviceType->name)
            ->map(fn($group, $service) => [$service, $group->count()])
            ->values()
            ->toArray();

        // 5) Agregar cada línea de resumen
        foreach ($summary as [$serviceName, $count]) {
            // El servicio en la segunda columna, la cantidad en la tercera
            $rows[] = ['', $serviceName, $count, ''];
        }
        return collect($rows);
    }

    public function headings(): array
    {
        return ['Fecha', 'Trabajador', 'Empresa', 'Servicio'];
    }
}
