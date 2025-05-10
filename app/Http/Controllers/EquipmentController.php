<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Services\InventoryLogger;

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
        $services = ServiceType::all();

        return view('admin.service_management.equipments.create', compact('employees', 'services'));
    }

    public function equipmentCreate(Request $request)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,employee_id',
            'service_id'        => 'required|exists:service_types,service_type_id',
            'equipment_name'    => 'required|string|max:100',
            'maintenance_date'  => 'required|date',
            'purchase_date'     => 'required|date',
            'equipment_status'  => 'required|in:operational,under_repair,out_of_service'
        ]);

        $equipment = Equipment::create([
            'employee_id'       => $validated['employee_id'],
            'service_id'        => $validated['service_id'],
            'equipment_name'    => $validated['equipment_name'],
            'maintenance_date'  => $validated['maintenance_date'],
            'purchase_date'     => $validated['purchase_date'],
            'equipment_status'  => $validated['equipment_status']
        ]);

        InventoryLogger::log([
            'equipment_id' => $equipment->equipment_id,
            'employee_id' => $equipment->employee_id,
            'source_type' => 'equipment',
            'source_id' => $equipment->equipment_id,
            'quantity' => 1,
            'movement_type' => 'in',
            'remarks' => 'New equipment created',
        ]);

        if (!$equipment) {
            return redirect()->back()->withCookies(['errors', 'Failed to store equipment']);
        }
        return redirect()->route('equipments.table')->with('success', 'Equipment created successfully');
    }

    public function equipmentEdit(Equipment $equipment)
    {
        $employees = Employee::with('user')
                    ->where('position_type_id', 2)
                    ->get();
        $services = ServiceType::all();

        return view('admin.service_management.equipments.create', compact('equipment', 'employees', 'services'));
    }

    public function equipmentUpdate(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'employee_id'       => 'required|exists:employees,employee_id',
            'service_id'        => 'required|exists:service_types,service_type_id',
            'equipment_name'    => 'required|string|max:100',
            'maintenance_date'  => 'required|date',
            'purchase_date'     => 'required|date',
            'equipment_status'  => 'required|in:operational,under_repair,out_of_service'
        ]);

        $equipment->update([
            'employee_id'       => $validated['employee_id'],
            'service_id'        => $validated['service_id'],
            'equipment_name'    => $validated['equipment_name'],
            'maintenance_date'  => $validated['maintenance_date'],
            'purchase_date'     => $validated['purchase_date'],
            'equipment_status'  => $validated['equipment_status']
        ]);

        InventoryLogger::log([
            'equipment_id' => $equipment->equipment_id,
            'employee_id' => $equipment->employee_id,
            'source_type' => 'equipment',
            'source_id' => $equipment->equipment_id,
            'quantity' => 0,
            'movement_type' => 'in',
            'remarks' => 'Equipment updated',
        ]);

        return redirect()->route('equipments.table')->with('success', 'Equipment updated successfully');
    }

    public function equipmentDelete(Equipment $equipment)
    {
        $equipment->delete();

        InventoryLogger::log([
            'equipment_id' => $equipment->equipment_id,
            'employee_id' => $equipment->employee_id,
            'source_type' => 'equipment',
            'source_id' => $equipment->equipment_id,
            'quantity' => -1,
            'movement_type' => 'out',
            'remarks' => 'Equipment deleted',
        ]);
        
        return redirect()->route('equipments.table')->with('success', 'Equipment deleted successfully');
    }
}
