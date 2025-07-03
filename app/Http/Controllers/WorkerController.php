<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\Company;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('workers.index', ['workers' => Worker::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workers.create', ['companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           Worker::create($request->only([
        'name', 'rut', 'email', 'address', 'phone', 'company_id'
    ]));

    return redirect()->route('workers.index');
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
      public function edit(Worker $worker)
    {
        $companies = Company::all();
        return view('workers.edit', compact('worker', 'companies'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required',
            'rut' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $worker->update($request->all());

        return redirect()->route('workers.index')->with('success', 'Trabajador actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('success', 'Trabajador eliminado correctamente.');
    }
}
