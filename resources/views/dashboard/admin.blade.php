@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Admin Dashboard</h1>

                {{-- Export Buttons --}}
                <div class="mb-4">
                    <a href="{{ route('dashboard.export.excel') }}" class="btn btn-success btn-sm">Export Excel</a>
                    <a href="{{ route('dashboard.export.pdf') }}" class="btn btn-danger btn-sm">Export PDF</a>
                </div>

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text fs-3">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Risks</h5>
                                <p class="card-text fs-3">{{ $totalRisks }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Mitigations</h5>
                                <p class="card-text fs-3">{{ $totalMitigations }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <h5>Current Stocks</h5>
                                <p>{{ $resources->sum('quantity') }} items available</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning shadow">
                            <div class="card-body">
                                <h5>Pending Requests</h5>
                                <p>{{ $pendingRequests }} requests</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <h5>Deliveries In-Transit</h5>
                                <p>{{ $inTransitDeliveries }} deliveries</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Risks Table --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h4 class="card-title">Recent Risks</h4>
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Likelihood</th>
                                                <th>Impact</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentRisks as $risk)
                                            <tr>
                                                <td>{{ $risk->title }}</td>
                                                <td>{{ $risk->category->name ?? '-' }}</td>
                                                <td>{{ $risk->likelihood }}</td>
                                                <td>{{ $risk->impact }}</td>
                                                <td>{{ $risk->status }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No recent risks found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional: Stock chart --}}
    <div class="mt-4 card shadow py-4 px-4">
        <canvas id="stockChart"></canvas>
    </div>
            </div>
        </div>
    </div>
</div>

    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($resources -> pluck('item')),
            datasets: [{
                label: 'Stock Quantity',
                data: @json($resources -> pluck('quantity')),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        },
    });
</script>

@endsection
