<?php

namespace App\Imports;

use App\Models\Worker;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;

class WorkersImport implements ToModel
{
    public function model(array $row)
    {
        
        // Buscar o crear empresa
        $company = Company::firstOrCreate(
            ['name' => $row[4]], // columna 5 = nombre empresa
            ['rut' => 'GEN-' . uniqid()] // rut inventado si no viene
        );

        return new Worker([
            'name' => $row[0],
            'rut' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'company_id' => $company->id,
        ]);
    }
}

