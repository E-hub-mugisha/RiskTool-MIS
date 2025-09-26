@extends('layouts.app')
@section('title','Reports')

@section('content')
<div class="container py-4">
    <h4 class="mb-3"><i class="bi bi-graph-up text-primary me-2"></i>Reports</h4>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" value="{{ $start }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" value="{{ $end }}">
        </div>
        <div class="col-md-3">
            <select name="region_id" class="form-select">
                <option value="">All Regions</option>
                @foreach($regions as $r)
                <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('reports.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        
    </div>

    <canvas id="summaryChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('summaryChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($requests->pluck('region.name')),
        datasets: [{
            label: 'Requested Qty',
            data: @json($requests->pluck('quantity')),
        }]
    }
});
</script>
@endsection
