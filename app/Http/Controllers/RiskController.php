<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\Department;
use App\Models\Category;
use App\Models\Region;
use App\Models\Resource;
use App\Models\ResourceAllocation;
use App\Models\ResourceRequest;
use App\Models\Shipment;
use App\Models\Staff;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function index()
    {
        $risks = Risk::with('region', 'category')->latest()->get();
        $regions = Region::all();
        $categories = Category::all();
        return view('risks.index', compact('risks', 'regions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'region_id' => 'required|exists:regions,id',
            'category_id' => 'required|exists:categories,id',
            'likelihood' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Low,Medium,High',
            'status' => 'nullable|in:Pending,In Progress,Mitigated,Escalated',
        ]);

        $risk = new Risk($validated);
        $risk->level = $risk->calculateRiskLevel(); // auto set risk level
        $risk->save();

        return redirect()->back()->with('success', 'Risk added with level: ' . $risk->level);
    }

    public function show(Risk $risk)
    {
        return response()->json($risk->load('department', 'category'));
    }

    public function update(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'region_id' => 'required|exists:regions,id',
            'category_id' => 'required|exists:categories,id',
            'likelihood' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Low,Medium,High',
            'status' => 'nullable|in:Pending,In Progress,Mitigated,Escalated',
        ]);

        $risk->fill($validated);
        $risk->level = $risk->calculateRiskLevel(); // recalculate level
        $risk->save();

        return redirect()->back()->with('success', 'Risk updated with level: ' . $risk->level);
    }

    public function destroy(Risk $risk)
    {
        $risk->delete();
        return redirect()->back()->with('success', 'Risk deleted successfully.');
    }

    public function indexRequest()
    {
        $requests = ResourceRequest::with('region')->latest()->get();
        $regions = Region::all();
        $resources = Resource::all();
        return view('resources.requests', compact('requests', 'regions', 'resources'));
    }

    public function RequestResources(Request $request)
    {
        $request->validate([
            'region_id'   => 'required',
            'resource_id' => 'required',
            'quantity'    => 'required',
        ]);


        $resource = Resource::findOrFail($request->resource_id);

        // ✅ Backend validation: Ensure not requesting more than available stock
        if ($request->quantity > $resource->quantity) {
            return back()->withErrors([
                'quantity' => "Requested quantity exceeds available stock (max {$resource->quantity})."
            ])->withInput();
        }

        ResourceRequest::create([
            'region_id'     => $request->region_id,
            'resource_id'   => $resource->id,
            'quantity'      => $request->quantity,
            'status'        => 'pending',
            'justification' => $request->justification,
        ]);


        return back()->with('success', 'Request submitted successfully!');
    }

    public function byRegion($regionId)
    {
        $resources = \App\Models\Resource::where('region_id', $regionId)->get();
        return response()->json($resources);
    }


    public function approveRequest($id)
    {
        $req = ResourceRequest::findOrFail($id);
        $req->update(['status' => 'approved']);
        return back()->with('success', 'Request approved.');
    }

    public function rejectRequest($id)
    {
        $req = ResourceRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);
        return back()->with('error', 'Request rejected.');
    }

    public function recommend($requestId)
    {
        // Fetch the resource request
        $req = ResourceRequest::findOrFail($requestId);

        // Fetch the requested resource
        $resource = Resource::findOrFail($req->resource_id);

        // Determine how much to allocate (cannot exceed either request quantity or available stock)
        $allocatedQuantity = min($resource->quantity, $req->quantity);

        if ($allocatedQuantity > 0) {
            // Create allocation
            ResourceAllocation::create([
                'request_id' => $req->id,
                'resource_id' => $resource->id,
                'allocated_quantity' => $allocatedQuantity,
                'status' => 'recommended',
            ]);

            // Optionally, you may reduce the resource stock
            $resource->quantity -= $allocatedQuantity;
            $resource->save();

            // Update request quantity if needed
            $req->quantity -= $allocatedQuantity;
            $req->save();
        }

        return redirect()->route('allocations.index')->with('success', 'System generated recommendation successfully.');
    }


    public function approveAllocation(ResourceAllocation $allocation)
    {
        $allocation->update(['status' => 'approved']);
        $allocation->resource->decrement('quantity', $allocation->allocated_quantity);
        return back()->with('success', 'Allocation approved and stock updated.');
    }

    public function rejectAllocation(ResourceAllocation $allocation)
    {
        $allocation->update(['status' => 'rejected']);
        return back()->with('error', 'Allocation rejected.');
    }

    public function indexAllocation()
    {
        // Fetch all allocations with related request and resource
        $allocations = ResourceAllocation::with(['request.region', 'resource'])->latest()->get();

        $staff = Staff::all();

        return view('resources.allocations', compact('allocations', 'staff'));
    }

    public function showAllocation($id)
    {
        $allocation = ResourceAllocation::with('request', 'resource')->findOrFail($id);
        return view('resources.allocation_detail', compact('allocation'));
    }

    public function indexShipment()
    {
        $shipments = Shipment::with('allocation', 'staff')->latest()->get();
        return view('resources.shipments', compact('shipments'));
    }

    public function storeShipment(Request $request)
    {
        $request->validate([
            'allocation_id' => 'required',
            'shipped_by' => 'required',
        ]);

        $trackNumber = 'TRK' . strtoupper(uniqid());
        $request->merge(['tracking_number' => $trackNumber]);

        $shipment = Shipment::create($request->all());

        return redirect()->route('shipments.show', $shipment->id)->with('success', 'Shipment recorded successfully!');
    }
    public function showShipment($id)
    {
        $shipment = Shipment::with('allocation', 'staff')->findOrFail($id);
        return view('resources.shipment_detail', compact('shipment'));
    }
}
