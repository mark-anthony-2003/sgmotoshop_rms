<?php

namespace App\Services;

use App\Models\Inventory;

class InventoryLogger
{
    public static function log(array $data): void
    {
        Inventory::create([
            'item_id' => $data['item_id'] ?? null,
            'employee_id' => $data['employee_id'] ?? null,
            'equipment_id' => $data['equipment_id'] ?? null,
            'source_type' => $data['source_type'],
            'source_id' => $data['source_id'],
            'quantity' => $data['quantity'],
            'movement_type' => $data['movement_type'],
            'remarks' => $data['remarks'] ?? null,
            'sales' => $data['sales'] ?? null,
        ]);
    }
}
