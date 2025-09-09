<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\ResourceRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeRequestResources(Request $request)
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

}
