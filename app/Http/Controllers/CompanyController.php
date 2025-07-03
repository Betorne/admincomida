<?php

namespace App\Http\Controllers;
use App\Models\Company;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('companies.index', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          Company::create($request->all());
        return redirect()->route('companies.index');
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
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rut' => 'required|string|max:20',
        ]);

        $company->update($request->only(['name', 'rut']));

        return redirect()->route('companies.index')->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(\App\Models\Company $company)
        {
            // Verifica si tiene trabajadores antes de eliminar, si quieres proteger
            if ($company->workers()->count() > 0) {
                return redirect()->route('companies.index')
                    ->with('error', 'No se puede eliminar una empresa con trabajadores asociados.');
            }

            $company->delete();

            return redirect()->route('companies.index')
                ->with('success', 'Empresa eliminada correctamente.');
        }

}
