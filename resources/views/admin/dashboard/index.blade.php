@extends('includes.app')

@section('title', 'Admin Panel')

@section('content')
<section class="flex justify-center items-center mt-18">
    <div class="w-full max-w-6xl px-6">
        <h2 class="text-4xl font-bold text-[#222831] mb-6">Dashboard</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-[#222831] mb-6">
            @foreach ([
                ['title' => 'Products', 'count' => $productsCount],
                ['title' => 'Services', 'count' => $servicesCount],
                ['title' => 'Employees', 'count' => $employeesCount],
                ['title' => 'Equipments', 'count' => $equipmentsCount]
            ] as $stat)
                <div class="bg-white border border-gray-200 shadow-sm rounded-md p-6">
                    <h2 class="font-medium">{{ $stat['title'] }}</h2>
                    <h1 class="text-4xl font-bold mt-1">{{ $stat['count'] }}</h1>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-md border border-gray-200 shadow-sm">
                <h2 class="text-lg font-semibold text-[#222831] mb-4">Stocks & Sold by Month</h2>
                <div id="item-stock-sales-chart" class="w-full"></div>
            </div>

            <div class="bg-white p-6 rounded-md border border-gray-200 shadow-sm">
                <h2 class="text-lg font-semibold text-[#222831] mb-4">Inventory Trends</h2>
                <div id="inventory-trend-chart" class="w-full"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Stocks & Sold by Month Bar Chart
        const stockSalesChart = new ApexCharts(document.querySelector("#item-stock-sales-chart"), {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false }
            },
            series: [
                { name: 'Total Stocks', data: @json($totalStocks) },
                { name: 'Total Sold', data: @json($totalSold) }
            ],
            xaxis: {
                categories: @json($months),
                labels: { style: { fontSize: '13px', colors: '#9ca3af' } }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                }
            },
            colors: ['#3b82f6', '#10b981'],
            legend: { position: 'top' },
            dataLabels: { enabled: false }
        });

        stockSalesChart.render();

        // Inventory Trend Chart
        const inventoryChart = new ApexCharts(document.querySelector("#inventory-trend-chart"), {
            chart: {
                type: 'line',
                height: 300,
                toolbar: { show: false }
            },
            series: [
                {
                    name: 'Product',
                    data: @json($productSeries)
                },
                {
                    name: 'Service',
                    data: @json($serviceSeries)
                }
            ],
            xaxis: {
                categories: @json($inventoryMonths),
                labels: {
                    style: { fontSize: '13px', colors: '#9ca3af' }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#6366f1', '#f59e0b'],
            legend: { position: 'top' },
            dataLabels: { enabled: false }
        });

        inventoryChart.render();
    });
</script>
@endpush
