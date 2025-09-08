<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Region;
use App\Models\Resource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'description' => 'required']);
        Region::create($request->only('name','description'));
        return back()->with('success', 'Region added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        $request->validate(['name' => 'required', 'description' => 'required']);
        $region->update($request->only('name','description'));
        return back()->with('success', 'Region updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return back()->with('success', 'Region deleted!');
    }

    public function indexResource()
    {
        $resources = Resource::latest()->get();
        $regions = Region::all();
        return view('resources.index', compact('resources', 'regions'));
    }

    public function storeResource(Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'nullable|date',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        Resource::create($request->all());
        return redirect()->back()->with('success', 'Resource added successfully.');
    }

    public function updateResource(Request $request, Resource $resource)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'nullable|date',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $resource->update($request->all());
        return redirect()->back()->with('success', 'Resource updated successfully.');
    }

    public function destroyResource(Resource $resource)
    {
        $resource->delete();
        return redirect()->back()->with('success', 'Resource deleted successfully.');
    }
}
