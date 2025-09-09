<?php

namespace App\Http\Controllers;

use App\Models\ResourceRequest;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RequestsExport;
use App\Models\Region;
use App\Models\Resource;

class ReportingController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end   = $request->input('end_date', Carbon::now()->toDateString());
        $region = $request->input('region_id');
        $resource = $request->input('resource_id');

        $query = ResourceRequest::with('region', 'resource')
            ->whereBetween('created_at', [$start, $end]);

        if ($region) $query->where('region_id', $region);
        if ($resource) $query->where('resource_id', $resource);

        $requests = $query->get();

        $regions = Region::all();
        $resources = Resource::all();

        return view('reports.index', compact('requests', 'start', 'end', 'regions', 'resources', 'region', 'resource'));
    }

    // CSV Export
    public function exportCsv(Request $request)
    {
        return Excel::download(new \App\Exports\RequestsExport($request), 'requests.csv');
    }

    // PDF Export
    public function exportPdf(Request $request)
    {
        $data = $this->filterData($request);
        $pdf = app(PDF::class);
        $pdf->loadView('reports.pdf', compact('data'));
        return $pdf->download('requests.pdf');
    }

    private function filterData($request)
    {
        $query = ResourceRequest::with('region', 'resource');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        if ($request->filled('resource_id')) {
            $query->where('resource_id', $request->resource_id);
        }

        return $query->get();
    }
}
