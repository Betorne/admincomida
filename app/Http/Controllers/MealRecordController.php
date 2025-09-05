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
        ->take(3)
        ->get();

    return view('meal-record.create', compact('services', 'recent'));
}

public function store(Request $request)
{

    $request->validate([
        'rut' => 'required|string',
        'service_type_id' => 'required|exists:service_types,id',
    ]);

    //dd($request->all());
    // 1. Buscar al trabajador
    $worker = Worker::where('rut', $request->rut)->first();
  if (!$worker) {
        return back()->withErrors(['rut' => 'No existe un trabajador con ese RUT.'])->withInput();
    }

    $now = now()->format('H:i:s');
    $service =$request->service_type_id;
  
    if (! $service) {
        return back()->with('error', 'No hay servicio activo en este momento');
    }

    $nameService = ServiceType::where('id', $request->service_type_id)->first();
    

    // 3. Crear el registro
    MealRecord::create([
        'worker_id'       => $worker->id,
        'service_type_id' => $service,
        'registered_at'   => now(),
    ]);
    
    return back()->with('success', 'Servicio '.$nameService->name.' , registrado  al Rut'.$request->rut);
}
}
