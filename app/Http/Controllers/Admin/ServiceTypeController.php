<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Models\ServiceType;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::latest()->paginate(10);
        return view('admin.service-types.index', compact('serviceTypes'));
    }

    public function create()
    {
        return view('admin.service-types.create');
    }

    public function store(StoreServiceTypeRequest $request)
    {
        ServiceType::create($request->validated());
        return redirect()->route('admin.service-types.index')->with('success', 'Service type created.');
    }

    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', compact('serviceType'));
    }

    public function update(StoreServiceTypeRequest $request, ServiceType $serviceType)
    {
        $serviceType->update($request->validated());
        return redirect()->route('admin.service-types.index')->with('success', 'Service type updated.');
    }

    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();
        return back()->with('success', 'Service type deleted.');
    }
}
