@extends('layouts.app')
@section('title','Resource Shipments')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4">
                    <div class="card-header">
                        <h4><i class="bi bi-truck text-primary me-2"></i> Resource Shipment Tracking {{ $shipment->tracking_number }}</h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tracking Number</th>
                                    <th>Allocation ID</th>
                                    <th>Shipped By</th>
                                    <th>Status</th>
                                    <th>Shipped At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $shipment->id }}</td>
                                    <td>{{ $shipment->tracking_number }}</td>
                                    <td>{{ $shipment->allocation_id }}</td>
                                    <td>{{ $shipment->staff->name ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($shipment->status) }}</td>
                                    <td>{{ $shipment->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button data-bs-toggle="modal" data-bs-target="#viewShipmentModal{{ $shipment->id }}" class="btn btn-sm btn-info">View</button>
                                        <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection