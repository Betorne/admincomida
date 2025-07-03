<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkersImport;

class WorkerImportController extends Controller
{
    public function form()
    {
        return view('workers.import');
        
    }
    

    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        Excel::import(new WorkersImport, $request->file('file'));

        return redirect()->route('workers.index')->with('success', 'Trabajadores importados con éxito');
    }





}
