<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Distribution;
use App\Models\DistributionPoint;
use App\Models\Region;
use App\Models\Resource;
use App\Models\ResourceAllocation;
use Illuminate\Http\Request;

class BeneficiariesController extends Controller
{
    //
    public function index()
    {
        $regions = Region::all();
        $beneficiaries = Beneficiary::with('region')->get();
        return view('beneficiaries.index', compact('beneficiaries', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'household_id' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        Beneficiary::create($request->all());
        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary created successfully.');
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'household_id' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $beneficiary->update($request->all());
        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary updated successfully.');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();
        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary deleted successfully.');
    }

    public function distributionPoints()
    {
        // This method can be implemented to handle distribution points if needed
        $regions = Region::all();
        $distributionPoints = DistributionPoint::with('region')->get();
        return view('beneficiaries.distribution_points', compact('regions', 'distributionPoints'));
    }

    public function storeDistributionPoint(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        DistributionPoint::create($request->all());
        return redirect()->route('distribution_points.index')->with('success', 'Distribution Point created successfully.');
    }

    public function updateDistributionPoint(Request $request, DistributionPoint $distributionPoint)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $distributionPoint->update($request->all());
        return redirect()->route('distribution_points.index')->with('success', 'Distribution Point updated successfully.');
    }

    public function destroyDistributionPoint(DistributionPoint $distributionPoint)
    {
        $distributionPoint->delete();
        return redirect()->route('distribution_points.index')->with('success', 'Distribution Point deleted successfully.');
    }

    public function indexDistribution()
    {
        // This method can be implemented to handle distributions if needed
        $distributions = Distribution::with('beneficiary')->get();
        $beneficiaries = Beneficiary::all();
        $distributionPoints = DistributionPoint::all();
        $allocations = ResourceAllocation::all();
        return view('beneficiaries.distributions', compact('distributions', 'beneficiaries', 'distributionPoints', 'allocations'));
    }

    public function storeDistribution(Request $request)
    {
        $request->validate([
            'beneficiary_id' => 'required',
            'distribution_point_id' => 'required',
            'quantity' => 'required',
            'delivered_at' => 'nullable',
            'allocation_id' => 'required',
        ]);

        // reduce stock in resource allocations
        $allocation = ResourceAllocation::find($request->allocation_id);

        $allocation->decrement('allocated_quantity', $request->quantity);

        Distribution::create($request->all());
        return redirect()->route('distributions.index')->with('success', 'Distribution created successfully.');
    }

    public function updateDistribution(Request $request, Distribution $distribution)
    {
        $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'resource_id' => 'required|exists:resources,id',
            'distribution_point_id' => 'required|exists:distribution_points,id',
            'quantity' => 'required|integer|min:1',
            'delivered_at' => 'nullable|date',
        ]);

        $distribution->update($request->all());
        return redirect()->route('distributions.index')->with('success', 'Distribution updated successfully.');
    }

    public function destroyDistribution(Distribution $distribution)
    {
        $distribution->delete();
        return redirect()->route('distributions.index')->with('success', 'Distribution deleted successfully.');
    }
}