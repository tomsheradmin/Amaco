@extends('backend.layouts.app')

@section('style')
<style>
    body {
        background-color: #f8fafc;
        color: #1e293b;
    }
    .widget-card {
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .widget-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.06);
    }
    .card-border-success { border-left: 4px solid #10b981; }
    .card-border-primary { border-left: 4px solid #6366f1; }
    .card-border-warning { border-left: 4px solid #f59e0b; }
    .card-border-info { border-left: 4px solid #06b6d4; }

    .widget-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.3s ease;
    }
    .widget-card:hover .widget-icon-box {
        transform: scale(1.1);
    }

    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
    .bg-soft-primary { background-color: rgba(99, 102, 241, 0.1) !important; color: #6366f1 !important; }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; }
    .bg-soft-info { background-color: rgba(6, 182, 212, 0.1) !important; color: #06b6d4 !important; }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; }

    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
    }

    .table-hover-custom tbody tr:hover {
        background-color: #f8fafc;
    }
    .table-thead-light th {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 12px 16px;
    }
    .table-hover-custom td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .product-list-item {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .product-list-item:last-child {
        border-bottom: none;
    }
    .product-img {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 12px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .badge-modern {
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 30px;
        display: inline-block;
    }
    .badge-modern-success { background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
    .badge-modern-danger { background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; }
    .badge-modern-warning { background-color: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; }
    .badge-modern-info { background-color: rgba(6, 182, 212, 0.1) !important; color: #06b6d4 !important; }
</style>
@endsection

@section('content')
    @if (Auth::user()->user_type == 'admin' || (Auth::user()->user_type == 'staff' && in_array('1', json_decode(Auth::user()->staff->role->permissions))))
        <!-- E-commerce KPI Cards Row -->
        <div class="row gutters-15">
           <!-- Customers -->
            <div class="col-xl-3 col-md-6 col-sm-12">
                <a href="{{ route('customers.index') }}" class="text-reset d-block" style="text-decoration: none;">
                    <div class="card widget-card card-border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="text-muted d-block mb-1 text-uppercase fs-10 fw-600" style="letter-spacing: 0.5px;">Total Customers</span>
                                    <h3 class="fw-700 mb-0 text-info">{{ $total_customers }}</h3>
                                </div>
                                <div class="widget-icon-box bg-soft-info">
                                    <i class="las la-users"></i>
                                </div>
                            </div>
                            <div class="pt-2 border-top border-slate-100 fs-11 d-flex justify-content-between text-muted">
                                <span>Today: <b>{{ $today_customers }}</b></span>
                                <span>Month: <b>{{ $this_month_customers }}</b></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row gutters-15">

        </div>

        <!-- Recent Orders & Top Selling Products Row -->
        <div class="row gutters-15">
            <!-- Recent Orders Table -->
            <div class="col-lg-8 mb-4">
                <
            </div>

            <!-- Top Selling Products -->
            <div class="col-lg-4 mb-4">

            </div>
        </div>




    @endif
@endsection


