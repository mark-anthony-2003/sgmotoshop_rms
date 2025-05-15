<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\{Employee, Equipment, Product, ServiceType};

class InventoryController extends Controller
{
    public function inventoryDashboard()
    {
        // Basic counts
        $productsCount = Product::count();
        $servicesCount = ServiceType::count();
        $employeesCount = Employee::count();
        $equipmentsCount = Equipment::count();

        // Shipment analytics
        $monthlyData = DB::table('shipments')
            ->join('carts', 'shipments.cart_id', '=', 'carts.cart_id')
            ->join('items', 'carts.item_id', '=', 'items.item_id')
            ->select(
                DB::raw('DATE_FORMAT(shipments.shipment_date, "%Y-%m") as month'),
                DB::raw('SUM(items.stocks) as total_stocks'),
                DB::raw('SUM(items.sold) as total_sold')
            )
            ->groupBy('month')
            
            ->orderBy('month')
            ->get();

        $months = $monthlyData->pluck('month')->toArray();
        $totalStocks = $monthlyData->pluck('total_stocks')->toArray();
        $totalSold = $monthlyData->pluck('total_sold')->toArray();

        $inventoryTrends = DB::table('inventories')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                'inventory_type',
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('month', 'inventory_type')
            ->orderBy('month')
            ->get();

        $grouped = $inventoryTrends->groupBy('inventory_type');

        $inventoryMonths = $inventoryTrends->pluck('month')->unique()->values()->toArray();

        $productData = $grouped['product']->pluck('total_amount', 'month')->toArray() ?? [];
        $serviceData = $grouped['service']->pluck('total_amount', 'month')->toArray() ?? [];

        $productSeries = array_map(fn($month) => $productData[$month] ?? 0, $inventoryMonths);
        $serviceSeries = array_map(fn($month) => $serviceData[$month] ?? 0, $inventoryMonths);
        

        return view('admin.dashboard.index', compact(
            'productsCount', 'servicesCount', 'employeesCount', 'equipmentsCount',
            'months', 'totalStocks', 'totalSold',
            'inventoryMonths', 'productSeries', 'serviceSeries'
        ));
    }
}
