<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
         $search = $request->input('search');

            $workers = Worker::query()
                ->when($search, function($q) use ($search) {
                    $q->where('name',    'like', "%{$search}%")
                    ->orWhere('rut',    'like', "%{$search}%")
                    ->orWhere('email',  'like', "%{$search}%")
                    ->orWhere('phone',  'like', "%{$search}%");
                })
                ->orderBy('name')
                ->paginate(15)
                ->appends(['search' => $search]);

            return view('workers.index', compact('workers', 'search'));
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
                $request->validate([
        'name'       => 'required|string|max:255',
        'rut'        => 'required|string|max:20|unique:workers,rut',
        'email'      => 'nullable|email|max:255',
        'phone'      => 'nullable|string|max:20',
        'company_id' => 'required|exists:companies,id',
            ], [    
    'rut.unique' => 'El RUT ya está registrado en otra empresa.',
    ]);


            Worker::create($request->only(['name','rut','email','phone','company_id']));

            return redirect()->route('workers.index')
                            ->with('success', 'Trabajador creado correctamente');

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
        'name'       => 'required|string|max:255',
        'rut'        => ['required','string','max:20',
            Rule::unique('workers','rut')->ignore($worker->id),
        ],
        'email'      => 'nullable|email|max:255',
        'phone'      => 'nullable|string|max:20',
        'company_id' => 'required|exists:companies,id',
        ],
        [
        'rut.unique' => 'El RUT ya está registrado en otra empresa.',
        ]);

        $worker->update($request->only(['name','rut','email','phone','company_id']));

        return redirect()->route('workers.index')
                        ->with('success', 'Trabajador actualizado correctamente');
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
