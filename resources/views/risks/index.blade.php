@extends('layouts.app')
@section('title','Risks')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0"><i class="bi bi-shield-exclamation me-2 text-danger"></i>Risk Management</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRiskModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Risk
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Department</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($risks as $index => $risk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $risk->title }}</td>
                                        <td>{{ $risk->department->name ?? 'N/A' }}</td>
                                        <td>{{ $risk->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $levelColors = ['Low' => 'success', 'Medium' => 'warning', 'High' => 'danger', 'Critical' => 'dark'];
                                            @endphp
                                            <span class="badge bg-{{ $levelColors[$risk->level] ?? 'secondary' }}">{{ $risk->level }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $risk->status == 'Active' ? 'success' : 'secondary' }}">{{ $risk->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
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

                                    {{-- Include modals --}}
                                    @include('risks.partials.show', ['risk' => $risk])
                                    @include('risks.partials.edit', ['risk' => $risk, 'departments' => $departments, 'categories' => $categories])
                                    @include('risks.partials.delete', ['risk' => $risk])
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
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('risks.store') }}">
                @csrf
                <div class="modal-content shadow rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add Risk</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input name="title" class="form-control mb-3" placeholder="Title" required>
                        <textarea name="description" class="form-control mb-3" placeholder="Description" required></textarea>

                        <select name="department_id" class="form-select mb-3" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>

                        <select name="category_id" class="form-select mb-3" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <select name="likelihood" class="form-select mb-3" required>
                            <option value="">-- Likelihood --</option>
                            @foreach (['Low', 'Medium', 'High'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>

                        <select name="impact" class="form-select mb-3" required>
                            <option value="">-- Impact --</option>
                            @foreach (['Low', 'Medium', 'High'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>

                        <select name="status" class="form-select" required>
                            <option value="">-- Status --</option>
                            @foreach (['Pending', 'In Progress', 'Mitigated', 'Escalated'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add Risk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
