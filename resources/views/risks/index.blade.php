@extends('layouts.app')
@section('title','Incidents')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center rounded-top-4">
                        <h4 class="card-title mb-0 fw-bold text-dark">
                            <i class="bi bi-shield-exclamation me-2 text-danger"></i>Incident Management
                        </h4>
                        <button class="btn btn-primary d-flex align-items-center gap-2 px-3" data-bs-toggle="modal" data-bs-target="#addRiskModal">
                            <i class="bi bi-plus-lg"></i> Add Incident
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-hover align-middle table-bordered rounded-3">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Region</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($risks as $index => $risk)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                        <td>{{ $risk->title }}</td>
                                        <td><i class="bi bi-geo-alt text-primary me-1"></i>{{ $risk->region->name ?? 'N/A' }}</td>
                                        <td><i class="bi bi-tag text-secondary me-1"></i>{{ $risk->category->name ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            @php
                                            $levelColors = ['Low' => 'success', 'Medium' => 'warning', 'High' => 'danger', 'Critical' => 'dark'];
                                            @endphp
                                            <span class="badge rounded-pill bg-{{ $levelColors[$risk->level] ?? 'secondary' }} px-3 py-2">
                                                {{ $risk->level }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill {{ $risk->status == 'Active' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                                {{ $risk->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm gap-2">
                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#showRiskModal{{ $risk->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editRiskModal{{ $risk->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRiskModal{{ $risk->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Show Modal --}}
                                    <div class="modal fade" id="showRiskModal{{ $risk->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header bg-info text-white rounded-top-4">
                                                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i> Incident Details</h5>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <p><strong>Title:</strong> {{ $risk->title }}</p>
                                                    <p><strong>Description:</strong> {{ $risk->description }}</p>
                                                    <p><strong>Region:</strong> {{ $risk->region->name ?? 'N/A' }}</p>
                                                    <p><strong>Category:</strong> {{ $risk->category->name ?? 'N/A' }}</p>
                                                    <p><strong>Level:</strong> {{ $risk->level }}</p>
                                                    <p><strong>Status:</strong> {{ $risk->status }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editRiskModal{{ $risk->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <form method="POST" action="{{ route('risks.update', $risk->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header bg-warning text-white rounded-top-4">
                                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Incident</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <input name="title" class="form-control" value="{{ $risk->title }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="region_id" class="form-select" required>
                                                                    <option value="">-- Select Region --</option>
                                                                    @foreach ($regions as $region)
                                                                    <option value="{{ $region->id }}" {{ $risk->region_id == $region->id ? 'selected' : '' }}>
                                                                        {{ $region->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <textarea name="description" class="form-control" rows="3" required>{{ $risk->description }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="category_id" class="form-select" required>
                                                                    <option value="">-- Select Category --</option>
                                                                    @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $risk->category_id == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="likelihood" class="form-select mb-3" required>
                                                                    <option value="">-- Likelihood --</option>
                                                                    @foreach (['Low', 'Medium', 'High'] as $option)
                                                                    <option value="{{ $option }}" {{ $risk->likelihood == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="impact" class="form-select mb-3" required>
                                                                    <option value="">-- Impact --</option>
                                                                    @foreach (['Low', 'Medium', 'High'] as $option)
                                                                    <option value="{{ $option }}" {{ $risk->impact == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="status" class="form-select" required>
                                                                    @foreach (['Pending', 'In Progress', 'Mitigated', 'Escalated'] as $status)
                                                                    <option value="{{ $status }}" {{ $risk->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-warning text-white px-4" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Delete Modal --}}
                                    <div class="modal fade" id="deleteRiskModal{{ $risk->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST" action="{{ route('risks.destroy', $risk->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header bg-danger text-white rounded-top-4">
                                                        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Delete Incident</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-center">
                                                        <p class="mb-0">Are you sure you want to delete <strong>{{ $risk->title }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer border-0 justify-content-center">
                                                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-danger px-4" type="submit">Delete</button>
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
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addRiskModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="{{ route('risks.store') }}">
                @csrf
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Add Incident</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input name="title" class="form-control" placeholder="Title" required>
                            </div>
                            <div class="col-md-6">
                                <select name="region_id" class="form-select" required>
                                    <option value="">-- Select Region --</option>
                                    @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea name="description" class="form-control" rows="3" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="likelihood" class="form-select mb-3" required>
                                    <option value="">-- Likelihood --</option>
                                    @foreach (['Low', 'Medium', 'High'] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="impact" class="form-select mb-3" required>
                                    <option value="">-- Impact --</option>
                                    @foreach (['Low', 'Medium', 'High'] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="status" class="form-select" required>
                                    <option value="">-- Status --</option>
                                    @foreach (['Pending', 'In Progress', 'Mitigated', 'Escalated'] as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary px-4" type="submit">Save Incident</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection