@extends('layouts.app')
@section('title','Resource Inventory')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm border-0 rounded-4">
                    {{-- Header --}}
                    <div class="card-header bg-white d-flex justify-content-between align-items-center rounded-top-4 border-0 shadow-sm">
                        <h4 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-box-seam text-primary me-2"></i> Resource Inventory
                        </h4>
                        <button class="btn btn-success btn-sm d-flex align-items-center gap-2 px-3" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                            <i class="bi bi-plus-lg"></i> Add Resource
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-hover align-middle table-bordered table-striped">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Expiry Date</th>
                                        <th>Region</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($resources as $index => $resource)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $resource->item }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $resource->quantity < 10 ? 'danger' : 'success' }}">
                                                {{ $resource->quantity }}
                                            </span>
                                        </td>
                                        <td>{{ $resource->unit }}</td>
                                        <td class="text-center">
                                            @if($resource->expiry_date)
                                            @php
                                            $expiry = \Carbon\Carbon::parse($resource->expiry_date);
                                            $badgeClass = $expiry->isPast() ? 'danger' : ($expiry->diffInDays(now()) <= 7 ? 'warning' : 'success' );
                                                @endphp
                                                <span class="badge bg-{{ $badgeClass }}">
                                                {{ $expiry->format('d M Y') }}
                                                </span>
                                                @else
                                                <span class="text-muted">N/A</span>
                                                @endif
                                        </td>
                                        <td>{{ $resource->region->name ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <div class="btn-group gap-2" role="group">
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editResourceModal{{ $resource->id }}" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteResourceModal{{ $resource->id }}" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editResourceModal{{ $resource->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('resources.update', $resource->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header bg-warning text-white rounded-top-4">
                                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Resource</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Item Name</label>
                                                                <input name="item" class="form-control mb-3" value="{{ $resource->item }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Quantity</label>
                                                                <input type="number" name="quantity" class="form-control mb-3" value="{{ $resource->quantity }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Unit</label>
                                                                <input name="unit" class="form-control mb-3" value="{{ $resource->unit }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Expiry Date</label>
                                                                <input type="date" name="expiry_date" class="form-control mb-3" value="{{ $resource->expiry_date }}">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Location (Region)</label>
                                                                <select name="region_id" class="form-select mb-3" required>
                                                                    <option value="">-- Select Location --</option>
                                                                    @foreach($regions as $region)
                                                                    <option value="{{ $region->id }}" {{ $region->id == $resource->region_id ? 'selected' : '' }}>
                                                                        {{ $region->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-warning text-white" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Delete Modal --}}
                                    <div class="modal fade" id="deleteResourceModal{{ $resource->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('resources.destroy', $resource->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header bg-danger text-white rounded-top-4">
                                                        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Resource</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p>Are you sure you want to delete <strong>{{ $resource->item }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer border-0 justify-content-center">
                                                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-danger" type="submit">Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No resources available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addResourceModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('resources.store') }}">
                @csrf
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add Resource</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Item Name</label>
                                <input name="item" class="form-control mb-3" placeholder="Item Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity & Unit</label>
                                <input type="number" name="quantity" class="form-control mb-3" placeholder="Quantity" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unit</label>
                                <input name="unit" class="form-control mb-3" placeholder="Unit (e.g. kg, liters)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control mb-3">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Location (Region)</label>
                                <select name="region_id" class="form-select mb-3" required>
                                    <option value="">-- Select Location --</option>
                                    @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection