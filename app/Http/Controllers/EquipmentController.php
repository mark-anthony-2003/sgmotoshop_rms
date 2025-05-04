<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function equipmentsTable()
    {
        $equipmentsList = Equipment::all();
        return view('admin.service_management.equipments.index', compact('equipmentsList'));
    }

    public function equipmentDetail(Equipment $equipment)
    {
        return view('admin.service_management.equipments.show', compact('equipment'));
    }

    public function equipmentForm()
    {
        $employees = Employee::with('user')
                    ->where('position_type_id', 2)
                    ->get();

        return view('admin.service_management.equipments.create', compact('employees'));
    }

    public function equipmentCreate(Request $request)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,employee_id',
            'service_id'        => 'required|exists:services,service_id',
            'equipment_name'    => 'required|string|max:100',
            'maintenance_date'  => 'required|date',
            'purchase_date'     => 'required|date',
            'equipment_status'  => 'required|in:operational,under_repair,out_of_service'
        ]);

        Equipment::create([
            'employee_id'       => $validated['employee_id'],
            'service_id'        => $validated['service_id'],
            'equipment_name'    => $validated['equipment_name'],
            'maintenance_date'  => $validated['maintenance_date'],
            'purchase_date'     => $validated['purchase_date'],
            'equipment_status'  => $validated['equipment_status']
        ]);

        return redirect()->route('equipments.table')->with('success', 'Equipment created successfully');
    }

    public function equipmentEdit(Equipment $equipment)
    {
        return view('admin.service_management.equipments.create', compact('equipment'));
    }

    public function equipmentUpdate(Request $request, Equipment $equipment)
    {
        // 
    }

    public function equipmentDelete(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.table')->with('success', 'Equipment deleted successfully');
    }
}
