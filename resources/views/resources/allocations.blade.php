@extends('layouts.app')
@section('title','Resource Allocation')
@section('content')
<div class="container">
    <h1>Resource Allocation</h1>
    <p>Manage your resource allocation requests here.</p>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Resource Allocations</h5>
            <div class="card-tools">
                <button class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#addAllocationModal">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Request</th>
                        <th>Allocated Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allocations as $allocation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>[{{ $allocation->request->region->name }}] {{ $allocation->request->item }}</td>
                        <td>{{ $allocation->allocated_quantity }}</td>
                        <td>{{ ucfirst($allocation->status) }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#viewAllocationModal{{ $allocation->id }}" class="btn btn-sm btn-info">View</button>
                            @if($allocation->status == 'pending' || $allocation->status == 'recommended')
                            <form method="POST" action="{{ route('allocations.approve', $allocation->id) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('allocations.reject', $allocation->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">Reject</button>
                            </form>
                            @elseif($allocation->status == 'approved')
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#dispatchModal{{ $allocation->id }}">Dispatch</button>

                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="viewAllocationModal{{ $allocation->id }}" tabindex="-1" aria-labelledby="viewAllocationModalLabel{{ $allocation->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewAllocationModalLabel{{ $allocation->id }}">Allocation Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Request:</strong> [{{ $allocation->request->region->name }}] {{ $allocation->request->item }}</p>
                                    <p><strong>Allocated Quantity:</strong> {{ $allocation->allocated_quantity }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($allocation->status) }}</p>
                                    <p><strong>Created At:</strong> {{ $allocation->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="dispatchModal{{ $allocation->id }}" tabindex="-1" aria-labelledby="dispatchModalLabel{{ $allocation->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('shipments.store') }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dispatchModalLabel{{ $allocation->id }}">Dispatch Shipment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="allocation_id" value="{{ $allocation->id }}">
                                        <div class="mb-3">
                                            <label for="staff_id{{ $allocation->id }}" class="form-label">Shipped By (Staff)</label>
                                            <select class="form-select" id="staff_id{{ $allocation->id }}" name="staff_id" required>
                                                <option value="">Select Staff</option>
                                                @foreach($staff as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Dispatch</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection