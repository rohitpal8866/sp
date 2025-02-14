@extends('admin.include.layout')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Bill Reports</h3>
                <p class="text-subtitle text-muted">View monthly or yearly bill summaries</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bill Reports</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Toggle Buttons -->
    <div class="d-flex justify-content-center mb-3">
        <button class="btn btn-primary mx-2" onclick="showReport('monthly')">Monthly Report</button>
        <button class="btn btn-success mx-2" onclick="showReport('yearly')">Yearly Report</button>
    </div>

    <section class="section">
        <div class="row">
            @php
                $groupedBills = $billMonthly->groupBy('year');
            @endphp

            <!-- Monthly Report -->
            <div id="monthly-report">
                @forelse($groupedBills as $year => $monthlyBills)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h4 class="mb-0 text-white">Year: {{ $year }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($monthlyBills as $bill)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border shadow-sm mb-3">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">
                                                        {{ date('F', mktime(0, 0, 0, $bill->month, 1)) }}
                                                    </h5>
                                                    <p class="text-muted mb-0">Total: <strong>₹{{ number_format($bill->total, 2) }}</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">No monthly billing data available.</div>
                    </div>
                @endforelse
            </div>

            <!-- Yearly Report -->
            <div id="yearly-report" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-success text-center">
                            <h4 class="mb-0 text-white">Yearly Bill Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($billYearly as $bill)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card border shadow-sm mb-3">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Year: {{ $bill->year }}</h5>
                                                <p class="text-muted mb-0">Total: <strong>₹{{ number_format($bill->total, 2) }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
    function showReport(type) {
        if (type === 'monthly') {
            document.getElementById('monthly-report').style.display = 'block';
            document.getElementById('yearly-report').style.display = 'none';
        } else {
            document.getElementById('monthly-report').style.display = 'none';
            document.getElementById('yearly-report').style.display = 'block';
        }
    }
</script>
@endpush
