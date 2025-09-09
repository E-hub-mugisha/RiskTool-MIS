@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="col-md-12">
                        <h1>Distributions</h1>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDistributionModal">Add Distribution</button>
                    </div>

                    <!-- Add Beneficiary Modal   -->
                    <div class="modal fade " id="addDistributionModal" tabindex="-1" aria-labelledby="addDistributionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDistributionModalLabel">Add Distribution</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body ">
                                    <form method="POST" action="{{ route('distributions.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="beneficiary_id" class="form-label">Beneficiary</label>
                                            <select class="form-select" id="beneficiary_id" name="beneficiary_id" required>
                                                @foreach($beneficiaries as $beneficiary)
                                                <option value="{{ $beneficiary->id }}">{{ $beneficiary->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="distribution_point_id" class="form-label">Distribution Point</label>
                                            <select class="form-select" id="distribution_point_id" name="distribution_point_id" required>
                                                @foreach($distributionPoints as $point)
                                                <option value="{{ $point->id }}">{{ $point->name }} - {{ $point->region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="allocation_id" class="form-label">Resource Allocation</label>
                                            <select class="form-select" id="allocation_id" name="allocation_id" required>
                                                @foreach($allocations as $allocation)
                                                <option value="{{ $allocation->id }}">{{ $allocation->resource->item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Distribution</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Beneficiary</th>
                                <th>Distribution Point</th>
                                <th>Allocation</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distributions as $distribution)
                            <tr>
                                <td>{{ $distribution->beneficiary->name }}</td>
                                <td>{{ $distribution->distributionPoint->name }}</td>
                                <td>{{ $distribution->allocation->resource->item }}</td>
                                <td>{{ $distribution->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editDistributionModal{{ $distribution->id }}">Edit</button>
                                    <!-- Edit Distribution Modal -->
                                    <div class="modal fade" id="editDistributionModal{{ $distribution->id }}" tabindex="-1" aria-labelledby="editDistributionModalLabel{{ $distribution->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDistributionModalLabel{{ $distribution->id }}">Edit Distribution</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('distributions.update', $distribution->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="beneficiary_id{{ $distribution->id }}" class="form-label">Beneficiary</label>
                                                            <select class="form-select" id="beneficiary_id{{ $distribution->id }}" name="beneficiary_id" required>
                                                                @foreach($beneficiaries as $beneficiary)
                                                                <option value="{{ $beneficiary->id }}" {{ $distribution->beneficiary_id == $beneficiary->id ? 'selected' : '' }}>{{ $beneficiary->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="distribution_point_id{{ $distribution->id }}" class="form-label">Distribution Point</label>
                                                            <select class="form-select" id="distribution_point_id{{ $distribution->id }}" name="distribution_point_id" required>
                                                                @foreach($distributionPoints as $point)
                                                                <option value="{{ $point->id }}" {{ $distribution->distribution_point_id == $point->id ? 'selected' : '' }}>{{ $point->name }} - {{ $point->region->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="allocation_id{{ $distribution->id }}" class="form-label">Resource Allocation</label>
                                                            <select class="form-select" id="allocation_id{{ $distribution->id }}" name="allocation_id" required>
                                                                @foreach($allocations as $allocation)
                                                                <option value="{{ $allocation->id }}" {{ $distribution->allocation_id == $allocation->id ? 'selected' : '' }}>{{ $allocation->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="quantity{{ $distribution->id }}" class="form-label">Quantity</label>
                                                            <input type="number" class="form-control" id="quantity{{ $distribution->id }}" name="quantity" value="{{ $distribution->quantity }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update Distribution</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('distributions.destroy', $distribution->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this distribution?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
@endsection