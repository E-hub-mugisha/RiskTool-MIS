@extends('layouts.app')
@section('title','Risks')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Risk Management</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <!-- Add Button -->
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRiskModal">Add Risk</button>

                            <!-- Risks Table -->
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Department</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($risks as $index => $risk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $risk->title }}</td>
                                        <td>{{ $risk->department->name ?? 'N/A' }}</td>
                                        <td>{{ $risk->category->name ?? 'N/A' }}</td>
                                        <td>{{ $risk->level }}</td>
                                        <td>{{ $risk->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showRiskModal{{ $risk->id }}">Show</button>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRiskModal{{ $risk->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRiskModal{{ $risk->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Show Modal -->
                                    <div class="modal fade" id="showRiskModal{{ $risk->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Risk Details</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Title:</strong> {{ $risk->title }}<br>
                                                    <strong>Description:</strong> {{ $risk->description }}<br>
                                                    <strong>Department:</strong> {{ $risk->department->name ?? 'N/A' }}<br>
                                                    <strong>Category:</strong> {{ $risk->category->name ?? 'N/A' }}<br>
                                                    <strong>Likelihood:</strong> {{ $risk->likelihood }}<br>
                                                    <strong>Impact:</strong> {{ $risk->impact }}<br>
                                                    <strong>Level:</strong> {{ $risk->level }}<br>
                                                    <strong>Status:</strong> {{ $risk->status }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editRiskModal{{ $risk->id }}">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('risks.update', $risk->id) }}">
                                                @csrf @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Edit Risk</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input name="title" value="{{ $risk->title }}" class="form-control mb-2" required>
                                                        <textarea name="description" class="form-control mb-2" required>{{ $risk->description }}</textarea>
                                                        <select name="department_id" class="form-control mb-2">
                                                            @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}" {{ $risk->department_id == $department->id ? 'selected' : '' }}>
                                                                {{ $department->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <select name="category_id" class="form-control mb-2">
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $risk->category_id == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <select name="likelihood" class="form-control mb-2">
                                                            @foreach (['Low', 'Medium', 'High'] as $option)
                                                            <option {{ $risk->likelihood == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                        <select name="impact" class="form-control mb-2">
                                                            @foreach (['Low', 'Medium', 'High'] as $option)
                                                            <option {{ $risk->impact == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                            @endforeach
                                                        </select>

                                                        <select name="status" class="form-control">
                                                            @foreach (['Pending', 'In Progress', 'Mitigated', 'Escalated'] as $status)
                                                            <option {{ $risk->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteRiskModal{{ $risk->id }}">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('risks.destroy', $risk->id) }}">
                                                @csrf @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Confirm Deletion</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this risk: <strong>{{ $risk->title }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-danger" type="submit">Delete</button>
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
    <!-- Add Modal -->
    <div class="modal fade" id="addRiskModal">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('risks.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Risk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input name="title" class="form-control mb-2" placeholder="Title" required>
                        <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
                        <select name="department_id" class="form-control mb-2" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <select name="category_id" class="form-control mb-2" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <select name="likelihood" class="form-control mb-2" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                        <select name="impact" class="form-control mb-2" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                        <select name="status" class="form-control" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Mitigated">Mitigated</option>
                            <option value="Escalated">Escalated</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection