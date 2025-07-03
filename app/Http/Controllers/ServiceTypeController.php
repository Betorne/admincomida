<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = ServiceType::all();
        return view('service-types.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return view('service-types.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        ServiceType::create([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'auto_activate' => $request->has('auto_activate'),
            'active' => $request->has('active'),
        ]);

        return redirect()->route('service-types.index')->with('success', 'Servicio creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceType $serviceType)
    {
        return view('service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, ServiceType $serviceType)
    {
        $request->validate([
            'name' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'auto_activate' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ]);

        $serviceType->update([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'auto_activate' => $request->input('auto_activate'),
            'active' => $request->input('active'),
        ]);

        return redirect()->route('service-types.index')->with('success', 'Servicio actualizado con éxito');

    }

    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();
        return redirect()->route('service-types.index');
    }
}
