<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealRecord;
use App\Models\Company;
use Carbon\Carbon;

use App\Exports\MealRecordsExport;

use Maatwebsite\Excel\Facades\Excel;
use PDF; // Barryvdh\DomPDF\Facade as PDF;


class ReportController extends Controller
{
    public function exportExcel(Request $request)
    {
        // Reusar lógica de filtro igual que en index()
        $records = $this->buildReportQuery($request)->get();
        return Excel::download(
            new MealRecordsExport($records),
            'meal_records_'.now()->format('Ymd').'.xlsx'
        );
    }
    public function exportPdf(Request $request)
    {
        $records = $this->buildReportQuery($request)->get();
        $pdf = PDF::loadView('reports.pdf', compact('records'));
        return $pdf->download('meal_records_'.now()->format('Ymd').'.pdf');
    }

    /**
     * Extrae la query con filtros de ReportController@index()
     */
    protected function buildReportQuery(Request $request)
    {
        $query = MealRecord::with(['worker.company','serviceType']);

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('registered_at', [$start, $end]);
        }
        if ($request->company_id) {
            $query->whereHas('worker', fn($q) => $q->where('company_id',$request->company_id));
        }
        return $query->orderBy('registered_at','desc');
    }
    public function index(Request $request)
    {
        // 1) Obtener lista de empresas para el filtro
        $companies = Company::orderBy('name')->get();

        // 2) Construir la query básica
        $query = MealRecord::with(['worker.company', 'serviceType']);

        // 3) Aplicar filtros de fecha
        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('registered_at', [$start, $end]);
        }

        // 4) Filtrar por empresa
        if ($request->company_id) {
            $query->whereHas('worker', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        // 5) Obtener y agrupar por nombre de servicio
        $records = $query->get();
        $reports = $records->groupBy(fn($r) => $r->serviceType->name);

        $summary = $reports->map(fn($group) => $group->count());

        // pasa $summary a la vista
        return view('reports.index', [
            'companies' => $companies,
            'reports'   => $reports,
            'summary'   => $summary,
            'filter'    => $request->only(['start_date','end_date','company_id']),
        ]);
    

      

    }
}