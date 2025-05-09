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

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Stocks & Sales -->
            <div class="bg-white p-6 rounded-md border border-gray-200 shadow-sm">
                <h2 class="text-lg font-semibold text-[#222831] mb-4">Stocks & Sales by Month</h2>
                <div id="item-stock-sales-chart" class="w-full"></div>
            </div>

            <!-- Finance Overview -->
            <div class="bg-white p-6 rounded-md border border-gray-200 shadow-sm">
                <h2 class="text-lg font-semibold text-[#222831] mb-4">Finance Overview</h2>
                <div id="finance-chart" class="w-full"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Stocks & Sales Bar Chart
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

        const financeChart = new ApexCharts(document.querySelector("#finance-chart"), {
            chart: {
                type: 'line',
                height: 300,
                toolbar: { show: false }
            },
            series: [{
                name: 'Total Sales',
                data: @json($financeSales)
            }],
            xaxis: {
                categories: @json($financeMonths),
                labels: { style: { fontSize: '13px', colors: '#9ca3af' } }
            },
            colors: ['#f59e0b'],
            stroke: { curve: 'smooth' },
            dataLabels: { enabled: false },
            markers: { size: 4 }
        });

        financeChart.render();
    });
</script>
@endpush
