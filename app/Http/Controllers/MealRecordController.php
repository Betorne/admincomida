<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Models\Worker;
use App\Models\MealRecord;

class MealRecordController extends Controller
{
public function create()
{
    $services = ServiceType::where('active', true)->get();
    $recent = MealRecord::with('worker', 'serviceType')
        ->latest('registered_at')
        ->take(10)
        ->get();

    return view('meal-record.create', compact('services', 'recent'));
}

public function store(Request $request)
{
    $request->validate([
        'rut' => 'required|string',
    ]);

    // 1. Buscar al trabajador
    $worker = Worker::where('rut', $request->rut)->first();
    if (! $worker) {
        return back()->with('error', 'Trabajador no encontrado');
    }

 $now = now()->format('H:i:s');
$service = ServiceType::where('active', true)
    ->where('auto_activate', true)
    ->where(function($q) use($now) {
        // Caso normal: inicio ≤ fin y ahora entre ellos
        $q->where(function($q2) use($now) {
            $q2->whereTime('start_time', '<=', $now)
               ->whereTime('end_time',   '>=', $now);
        })
        // Caso medianoche: inicio > fin y (ahora ≥ inicio OR ahora ≤ fin)
        ->orWhere(function($q2) use($now) {
            $q2->whereRaw('start_time > end_time')
               ->where(function($q3) use($now) {
                   $q3->whereTime('start_time', '<=', $now)
                      ->orWhereTime('end_time', '>=', $now);
               });
        });
    })
    ->first();


    


    if (! $service) {
        return back()->with('error', 'No hay servicio activo en este momento');
    }

    // 3. Crear el registro
    MealRecord::create([
        'worker_id'       => $worker->id,
        'service_type_id' => $service->id,
        'registered_at'   => now(),
    ]);

    return back()->with('success', 'Comida registrada: '.$service->name);
}
}
