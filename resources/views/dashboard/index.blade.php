@extends('layouts.layout')
@section('breadcame')
    Dashboard
@endsection
@section('content')
    <div class="row g-4">
        <!-- Card Template -->
        <div class="col-md-6">
            <div class="card bg-gradient bg-success text-white shadow-lg border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-3 fw-bold mb-1">Total Agent</div>
                        <div class="fs-1 fw-bolder">5</div>
                    </div>
                    <div class="display-4">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-gradient bg-info text-white shadow-lg border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-3 fw-bold mb-1">Total Terminal</div>
                        <div class="fs-1 fw-bolder">10</div>
                    </div>
                    <div class="display-4">
                        <i class="fas fa-desktop text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-gradient bg-primary text-white shadow-lg border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-3 fw-bold mb-1">Total Party</div>
                        <div class="fs-1 fw-bolder">1</div>
                    </div>
                    <div class="display-4">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-gradient bg-warning text-dark shadow-lg border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-3 fw-bold mb-1">Total Jon</div>
                        <div class="fs-1 fw-bolder">$93.46</div>
                    </div>
                    <div class="display-4 text-dark">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5 mt-5">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">This Month's Total Job</h5>
        </div>
        <div class="card-body">
            <canvas id="monthlyJobsChart" height="120"></canvas>
        </div>
    </div>
@endsection

@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyJobsChart').getContext('2d');

    const monthlyJobsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Jobs Completed',
                data: [12, 19, 8, 14], // Update with dynamic values if needed
                backgroundColor: [
                    '#28a745', '#17a2b8', '#ffc107', '#007bff'
                ],
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#343a40',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            }
        }
    });
</script>

@endpush
