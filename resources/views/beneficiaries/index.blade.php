@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="col-md-12">
                        <h1>Beneficiaries</h1>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBeneficiaryModal">Add Beneficiary</button>
                    </div>

                    <!-- Add Beneficiary Modal   -->
                    <div class="modal fade" id="addBeneficiaryModal" tabindex="-1" aria-labelledby="addBeneficiaryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBeneficiaryModalLabel">Add Beneficiary</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('beneficiaries.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="household_id" class="form-label">Household ID</label>
                                            <input type="text" class="form-control" id="household_id" name="household_id">
                                        </div>
                                        <div class="mb-3">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="contact" name="contact">
                                        </div>
                                        <div class="mb-3">
                                            <label for="region_id" class="form-label">Region</label>
                                            <select class="form-select" id="region_id" name="region_id" required>
                                                @foreach($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Beneficiary</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Household ID</th>
                                <th>Contact</th>
                                <th>Region</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beneficiaries as $beneficiary)
                            <tr>
                                <td>{{ $beneficiary->name }}</td>
                                <td>{{ $beneficiary->household_id }}</td>
                                <td>{{ $beneficiary->contact }}</td>
                                <td>{{ $beneficiary->region->name ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBeneficiaryModal{{ $beneficiary->id }}">Edit</button>
                                    <form action="{{ route('beneficiaries.destroy', $beneficiary->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Beneficiary Modal -->
                            <div class="modal fade" id="editBeneficiaryModal{{ $beneficiary->id }}" tabindex="-1" aria-labelledby="editBeneficiaryModalLabel{{ $beneficiary->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editBeneficiaryModalLabel{{ $beneficiary->id }}">Edit Beneficiary</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('beneficiaries.update', $beneficiary->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name{{ $beneficiary->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name{{ $beneficiary ->id }}" name="name" value="{{ $beneficiary->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="household_id{{ $beneficiary->id }}" class="form-label">Household ID</label>
                                                    <input type="text" class="form-control" id="household_id{{ $beneficiary->id }}" name="household_id" value="{{ $beneficiary->household_id }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contact{{ $beneficiary->id }}" class="form-label">Contact</label>
                                                    <input type="text" class="form-control" id="contact{{ $beneficiary->id }}" name="contact" value="{{ $beneficiary->contact }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Beneficiary</button>
                                            </form>
                                        </div>
                                    </div>
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
@endsection