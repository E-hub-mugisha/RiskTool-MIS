@extends('layouts.app')
@section('title','Resource Shipments')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4">
                    <div class="card-header">
                        <h4><i class="bi bi-truck text-primary me-2"></i> Resource Shipments</h4>
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
                                @foreach($shipments as $shipment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($shipments as $shipment)
    <div class="modal fade" id="viewShipmentModal{{ $shipment->id }}" tabindex="-1" aria-labelledby="viewShipmentModalLabel{{ $shipment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewShipmentModalLabel{{ $shipment->id }}">Shipment Details - {{ $shipment->tracking_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Allocation ID:</strong> {{ $shipment->allocation_id }}</p>
                    <p><strong>Shipped By:</strong> {{ $shipment->staff->name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($shipment->status) }}</p>
                    <p><strong>Shipped At:</strong> {{ $shipment->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection