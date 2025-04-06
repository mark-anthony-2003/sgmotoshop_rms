<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function servicesTable()
    {
        $serviceTypesList = ServiceType::all();
        return view('admin.service_management.services.index', compact('serviceTypesList'));
    }

    public function serviceTypeDelete(ServiceType $serviceType)
    {
        $serviceType->delete();
        return redirect()->route('serviceTypes-table')->with('success', 'Service Type deleted successfully');
    }
}
