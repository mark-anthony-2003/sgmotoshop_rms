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

        // Finance Overview: Monthly Sales from inventories
        $financeData = DB::table('inventories')
            ->whereNotNull('sales')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(sales) as total_sales')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $financeMonths = $financeData->pluck('month')->toArray();
        $financeSales = $financeData->pluck('total_sales')->toArray();
        

        return view('admin.dashboard.index', compact(
            'productsCount', 'servicesCount', 'employeesCount', 'equipmentsCount',
            'months', 'totalStocks', 'totalSold',
            'financeMonths', 'financeSales'
        ));
    }
}
