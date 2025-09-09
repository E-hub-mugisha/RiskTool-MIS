@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="col-md-12">
                        <h1>Distribution points</h1>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDistributionPointModal">Add Distribution Point</button>
                    </div>

                    <!-- Add Beneficiary Modal   -->
                    <div class="modal fade " id="addDistributionPointModal" tabindex="-1" aria-labelledby="addDistributionPointModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDistributionPointModalLabel">Add Distribution Point</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body ">
                                    <form method="POST" action="{{ route('distribution_points.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="region_id" class="form-label">Region</label>
                                            <select class="form-select" id="region_id" name="region_id" required>
                                                @foreach($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Distribution Point</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Region</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distributionPoints as $point)
                            <tr>
                                <td>{{ $point->name }}</td>
                                <td>{{ $point->region->name }}</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editDistributionPointModal{{ $point->id }}">Edit</button>
                                    <form action="{{ route('distribution_points.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this distribution point?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Distribution Point Modal -->
                            <div class="modal fade" id="editDistributionPointModal{{ $point->id }}" tabindex="-1" aria-labelledby="editDistributionPointModalLabel{{ $point->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDistributionPointModalLabel{{ $point->id }}">Edit Distribution Point</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('distribution_points.update', $point->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name{{ $point->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name{{ $point->id }}" name="name" value="{{ $point->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="region_id{{ $point->id }}" class="form-label">Region</label>
                                                    <select class="form-select" id="region_id{{ $point->id }}" name="region_id" required>
                                                        @foreach($regions as $region)
                                                        <option value="{{ $region->id }}" {{ $point->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Distribution Point</button>
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