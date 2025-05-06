<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function services()
    {
        $services = ServiceType::all();
        return view('pages.services.index', compact('services'));
    }

    public function servicesTable()
    {
        $serviceTypesList = ServiceType::all();
        return view('admin.service_management.services.index', compact('serviceTypesList'));
    }

    public function serviceTypeDetail(ServiceType $serviceType)
    {
        return view('admin.service_management.services.show', compact('serviceType'));
    }

    public function serviceTypeForm()
    {
        return view('admin.service_management.services.create');
    }

    public function serviceTypeCreate(Request $request)
    {
        $validated = $request->validate([
            'service_name'      => 'required|string|max:100',
            'price'             => 'required|integer',
            'image'             => 'nullable|image|mimes:png,jpg|max:5000',
            'service_status'    => 'required|in:available,not_available'
        ]);

        $serviceTypeImagePath = null;
        if ($request->hasFile('image')) {
            $serviceTypeImagePath = $request->file('image')->store('service_types_images', 'public');
        }

        $serviceType = ServiceType::create([
            'service_name'      => $validated['service_name'],
            'price'             => $validated['price'],
            'image'             => $serviceTypeImagePath,
            'service_status'    => $validated['service_status']    
        ]);

        if (!$serviceType) {
            return redirect()->back()->withErrors(['error', 'Failed to store service type.']);
        }
        return redirect()->route('serviceTypes.table')->with('success', 'Service Type created successfully');
    }

    public function serviceTypeEdit(ServiceType $serviceType)
    {
        return view('admin.service_management.services.create', compact('serviceType'));
    }

    public function serviceTypeUpdate(Request $request, ServiceType $serviceType)
    {
        $validated = $request->validate([
            'service_name'      => 'required|string|max:100',
            'price'             => 'required|integer',
            'image'             => 'nullable|image|mimes:png,jpg|max:5000',
            'service_status'    => 'required|in:available,not_available'
        ]);

        $serviceTypeImagePath = $serviceType->image;
        if ($request->hasFile('image')) {
            $serviceTypeImagePath = $request->file('image')->store('service_types_images', 'public');
        }

        $serviceType->update([
            'service_name'      => $validated['service_name'],
            'price'             => $validated['price'],
            'image'             => $serviceTypeImagePath,
            'service_status'    => $validated['service_status']    
        ]);

        return redirect()->route('serviceTypes.table')->with('success', 'Service Type updated successfully');
    }

    public function serviceTypeDelete(ServiceType $serviceType)
    {
        $serviceType->delete();
        return redirect()->route('serviceTypes.table')->with('success', 'Service Type deleted successfully');
    }
}
