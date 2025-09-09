@extends('layouts.app')
@section('title','Resource Requests')
@section('content')

<div class="container py-4">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4><i class="bi bi-clipboard-check text-primary me-2"></i> Resource Requests</h4>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addRequestModal">
                            <i class="bi bi-plus-lg"></i> New Request
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Region</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                <tr>
                                    <td>{{ $req->id }}</td>
                                    <td>{{ $req->region->name }}</td>
                                    <td>{{ $req->resource->item }}</td>
                                    <td>{{ $req->quantity }}</td>
                                    <td>
                                        <span class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'rejected' ? 'danger':'warning') }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($req->status == 'pending')
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewJustificationModal{{ $req->id }}">View Justification</button>
                                        <!-- Justification Modal -->
                                        <div class="modal fade" id="viewJustificationModal{{ $req->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header bg-info text-white rounded-top-4">
                                                        <h5 class="modal-title">Justification for Request #{{ $req->id }}</h5>
                                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $req->justification ?? 'No justification provided.' }}</p>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                        <form method="POST" action="{{ route('requests.reject',$req->id) }}" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger">Reject</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('requests.approve',$req->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-success">Approve</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <a href="{{ route('allocations.recommend',$req->id) }}" class="btn btn-sm btn-primary">Recommend Allocation</a>
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

    {{-- Add Request Modal --}}
    <div class="modal fade" id="addRequestModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('storeRequestResources') }}">
                @csrf
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title">New Request</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select name="region_id" id="regionSelect" class="form-select mb-3" required>
                            <option value="">-- Select Region --</option>
                            @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>

                        <select name="resource_id" id="resourceSelect" class="form-select mb-3" required>
                            <option value="">-- Select Resource --</option>
                        </select>

                        <input type="number" id="quantityInput" name="quantity" class="form-control mb-3" placeholder="Quantity" min="1" required>
                        <textarea name="justification" class="form-control" placeholder="Justification (optional)"></textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- AJAX Script for dynamic resources --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const regionSelect = document.getElementById("regionSelect");
        const resourceSelect = document.getElementById("resourceSelect");
        const quantityInput = document.getElementById("quantityInput");

        regionSelect.addEventListener("change", function() {
            const regionId = this.value;

            resourceSelect.innerHTML = '<option value="">Loading...</option>';
            quantityInput.value = "";
            quantityInput.removeAttribute("max");
            quantityInput.placeholder = "Quantity";

            if (!regionId) {
                resourceSelect.innerHTML = '<option value="">-- Select Resource --</option>';
                return;
            }

            fetch(`/get/regions/${regionId}/resources`)
                .then(res => res.json())
                .then(data => {
                    resourceSelect.innerHTML = '<option value="">-- Select Resource --</option>';
                    data.forEach(resource => {
                        resourceSelect.innerHTML += `
                        <option value="${resource.id}" data-stock="${resource.quantity}">
                            ${resource.item} (${resource.quantity} ${resource.unit} available)
                        </option>`;
                    });
                })
                .catch(() => {
                    resourceSelect.innerHTML = '<option value="">Error loading resources</option>';
                });
        });

        resourceSelect.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute("data-stock");

            if (stock) {
                quantityInput.max = stock;
                quantityInput.value = "";
                quantityInput.placeholder = `Max: ${stock}`;
            } else {
                quantityInput.removeAttribute("max");
                quantityInput.placeholder = "Quantity";
            }
        });
    });
</script>

@endsection