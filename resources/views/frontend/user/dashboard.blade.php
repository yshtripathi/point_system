@extends('frontend.layouts.main')
@section('main-content')

<div class="tl-breadcrumb about-banner pt-60 pb-60">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.my_account') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.my_account') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="account-section pt-60 pb-80 bg-light" style="position: relative; overflow: hidden;">
    <!-- Decorative Blobs -->
    <div class="modern-blob modern-blob-1" style="top: -100px; left: -100px; width: 400px; height: 400px; background: var(--primary-10);"></div>
    <div class="modern-blob modern-blob-2" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: var(--primary-10);"></div>

    <div class="container">
        <!-- Stats Cards -->
        <div class="row mb-5 g-4">
            <div class="col-lg-3 col-md-6">
                <div class="modern-card stat-card p-4 bg-white border-0 shadow-lg overflow-hidden" style="border-radius: 16px; position: relative; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.98) 100%); border: 1px solid rgba(21, 145, 220, 0.1);">
                    <div class="position-absolute top-0 end-0 w-50 h-100" style="background: linear-gradient(135deg, rgba(21, 145, 220, 0.03) 0%, transparent 100%); border-radius: 16px;"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <i class="fas fa-coins fa-2x" style="color: #1591DC; opacity: 0.8;"></i>
                            <span class="badge" style="background: rgba(21, 145, 220, 0.1); color: #1591DC; font-size: 10px; padding: 4px 8px;">BALANCE</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('common.available_credits') ?? 'Available Points' }}</p>
                        <h3 class="mb-0 fw-800" style="color: #0a0e27; font-size: 28px;">{{ Auth::user()->points_balance ?? 0 }} <span style="font-size: 18px; color: #1591DC; font-weight: 600;">PTS</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card stat-card p-4 bg-white border-0 shadow-lg overflow-hidden" style="border-radius: 16px; position: relative; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.98) 100%); border: 1px solid rgba(255, 193, 7, 0.1);">
                    <div class="position-absolute top-0 end-0 w-50 h-100" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.03) 0%, transparent 100%); border-radius: 16px;"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <i class="fas fa-book-open fa-2x" style="color: #FFC107; opacity: 0.8;"></i>
                            <span class="badge" style="background: rgba(255, 193, 7, 0.1); color: #FFC107; font-size: 10px; padding: 4px 8px;">COURSES</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Courses Enrolled</p>
                        <h3 class="mb-0 fw-800" style="color: #0a0e27; font-size: 28px;">{{ isset($redeemedOrders) ? count($redeemedOrders) : 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card stat-card p-4 bg-white border-0 shadow-lg overflow-hidden" style="border-radius: 16px; position: relative; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.98) 100%); border: 1px solid rgba(40, 167, 69, 0.1);">
                    <div class="position-absolute top-0 end-0 w-50 h-100" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.03) 0%, transparent 100%); border-radius: 16px;"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <i class="fas fa-check-circle fa-2x" style="color: #28a745; opacity: 0.8;"></i>
                            <span class="badge" style="background: rgba(40, 167, 69, 0.1); color: #28a745; font-size: 10px; padding: 4px 8px;">STATS</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Completed</p>
                        <h3 class="mb-0 fw-800" style="color: #0a0e27; font-size: 28px;">{{ isset($redeemedOrders) ? count($redeemedOrders->where('status', 'Completed')) : 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card stat-card p-4 bg-white border-0 shadow-lg overflow-hidden" style="border-radius: 16px; position: relative; background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.98) 100%); border: 1px solid rgba(108, 117, 125, 0.1);">
                    <div class="position-absolute top-0 end-0 w-50 h-100" style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.03) 0%, transparent 100%); border-radius: 16px;"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <i class="fas fa-calendar-alt fa-2x" style="color: #6c757d; opacity: 0.8;"></i>
                            <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 10px; padding: 4px 8px;">MEMBER</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Member Since</p>
                        <h3 class="mb-0 fw-800" style="color: #0a0e27; font-size: 28px;">{{ Auth::user()->created_at->format('M') }}<span style="font-size: 16px; color: #6c757d; font-weight: 600;"> {{ Auth::user()->created_at->format('Y') }}</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4 border-0 bg-white rounded-3 shadow-md p-3 p-md-4" id="dashboardTabs" role="tablist" style="border-radius: 16px;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="points-purchased-tab" data-bs-toggle="tab" data-bs-target="#points-purchased" type="button" role="tab" aria-controls="points-purchased" aria-selected="true" style="color: #666; font-size: 15px;">
                    <i class="fas fa-wallet me-2"></i>Points Purchased
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="points-redeemed-tab" data-bs-toggle="tab" data-bs-target="#points-redeemed" type="button" role="tab" aria-controls="points-redeemed" aria-selected="false" style="color: #666; font-size: 15px;">
                    <i class="fas fa-graduation-cap me-2"></i>Points Redeemed
                </button>
            </li>
            <li class="ms-auto">
                <a href="{{ route('user.logout') }}" class="nav-link fw-bold text-danger" style="font-size: 15px;">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="dashboardContent">
            <!-- Points Purchased Tab -->
            <div class="tab-pane fade show active" id="points-purchased" role="tabpanel" aria-labelledby="points-purchased-tab">
                <div class="modern-card bg-white border-0 shadow-lg p-4 p-md-5" style="border-radius: 16px; border: 1px solid rgba(21, 145, 220, 0.1);">
                    <h3 class="mb-4 fw-bold" style="color: #0a0e27;">
                        <i class="fas fa-wallet me-2" style="color: #FFC107;"></i>Points Purchased (Wallet Top-ups)
                    </h3>

                    @if(isset($purchasedOrders) && count($purchasedOrders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead style="background: rgba(21, 145, 220, 0.05); border-bottom: 2px solid rgba(21, 145, 220, 0.2);">
                                    <tr>
                                        <th style="color: #1591DC; font-weight: 600;">Order Number</th>
                                        <th style="color: #1591DC; font-weight: 600;">Points Bought</th>
                                        <th style="color: #1591DC; font-weight: 600;">Price Paid</th>
                                        <th style="color: #1591DC; font-weight: 600;">Payment Status</th>
                                        <th style="color: #1591DC; font-weight: 600;">Date</th>
                                        <th style="color: #1591DC; font-weight: 600;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchasedOrders as $order)
                                    <tr>
                                        <td class="fw-bold" style="color: #0a0e27;">{{ $order->order_number }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="fas fa-coins me-1"></i>{{ number_format($order->cart_info->sum('points')) }} PTS
                                            </span>
                                        </td>
                                        <td>{{ Helper::getCurrencySymbol($order->currency) }}{{ number_format($order->total_amount, $order->currency=='JPY' ? 0 : 2) }}</td>
                                        <td>
                                            @if(strtolower($order->payment_status) === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{route('user.order.show', $order->id)}}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x mb-3" style="color: rgba(21, 145, 220, 0.2);"></i>
                            <h5 class="text-muted mt-3">No wallet top-ups yet</h5>
                            <p class="text-muted mb-4">You haven't purchased any points yet. <a href="{{ route('product-lists') }}" class="text-primary fw-bold">Browse courses to get started</a></p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Points Redeemed Tab -->
            <div class="tab-pane fade" id="points-redeemed" role="tabpanel" aria-labelledby="points-redeemed-tab">
                <div class="modern-card bg-white border-0 shadow-lg p-4 p-md-5" style="border-radius: 16px; border: 1px solid rgba(21, 145, 220, 0.1);">
                    <h3 class="mb-4 fw-bold" style="color: #0a0e27;">
                        <i class="fas fa-graduation-cap me-2" style="color: #1591DC;"></i>Points Redeemed (Course Enrollments)
                    </h3>

                    @if(isset($redeemedOrders) && count($redeemedOrders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead style="background: rgba(21, 145, 220, 0.05); border-bottom: 2px solid rgba(21, 145, 220, 0.2);">
                                    <tr>
                                        <th style="color: #1591DC; font-weight: 600;">Order Number</th>
                                        <th style="color: #1591DC; font-weight: 600;">Course Name</th>
                                        <th style="color: #1591DC; font-weight: 600;">Level</th>
                                        <th style="color: #1591DC; font-weight: 600;">Points Used</th>
                                        <th style="color: #1591DC; font-weight: 600;">Status</th>
                                        <th style="color: #1591DC; font-weight: 600;">Date</th>
                                        <th style="color: #1591DC; font-weight: 600;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($redeemedOrders as $order)
                                    @php
                                        $cartItem = $order->cart_info->first();
                                        $level = null;
                                        if($cartItem) {
                                            $level = \App\Models\ProductLevel::where('course_id', $cartItem->product_id)
                                                                             ->where('price_in_points', $cartItem->points)
                                                                             ->first();
                                        }
                                    @endphp
                                    <tr>
                                        <td class="fw-bold" style="color: #0a0e27;">{{ $order->order_number }}</td>
                                        <td style="color: #0a0e27;">{{ $cartItem ? $cartItem->product->title : 'N/A' }}</td>
                                        <td>
                                            @if($level)
                                                <span class="badge bg-info">{{ $level->skill_level }}</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="fas fa-coins me-1"></i>{{ number_format($order->cart_info->sum('points')) }} PTS
                                            </span>
                                        </td>
                                        <td>
                                            @if(strtolower($order->status) === 'completed')
                                                <span class="badge bg-success">Redeemed</span>
                                            @else
                                                <span class="badge bg-warning">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{route('user.order.show', $order->id)}}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-4x mb-3" style="color: rgba(21, 145, 220, 0.2);"></i>
                            <h5 class="text-muted mt-3">No course enrollments yet</h5>
                            <p class="text-muted mb-4">You haven't redeemed any points for courses yet. <a href="{{ route('coursecart') }}" class="text-primary fw-bold">Browse and enroll in courses</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .account-section {
        position: relative;
    }

    .modern-blob {
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        animation: blobAnimation 8s infinite;
        opacity: 0.6;
    }

    .modern-blob-1 {
        animation-delay: 0s;
    }

    .modern-blob-2 {
        animation-delay: 4s;
    }

    @keyframes blobAnimation {
        0%, 100% {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            transform: translate(0, 0);
        }
        33% {
            border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
            transform: translate(20px, -20px);
        }
        66% {
            border-radius: 70% 30% 70% 30% / 30% 70% 70% 30%;
            transform: translate(-20px, 20px);
        }
    }

    .stat-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        animation: slideInUp 0.6s ease-out;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(21, 145, 220, 0.15) !important;
    }

    .modern-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 40px rgba(21, 145, 220, 0.12) !important;
    }

    .nav-tabs {
        gap: 8px;
    }

    .nav-tabs .nav-link {
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        font-size: 15px;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 12px 12px 0 0;
    }

    .nav-tabs .nav-link:hover {
        color: #1591DC;
        background-color: rgba(21, 145, 220, 0.05);
        border-bottom-color: rgba(21, 145, 220, 0.3);
    }

    .nav-tabs .nav-link.active {
        color: #1591DC;
        border-bottom-color: #1591DC;
        background: rgba(21, 145, 220, 0.05);
    }

    .tab-content {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    table {
        border-collapse: separate;
        border-spacing: 0;
    }

    table thead th {
        background: rgba(21, 145, 220, 0.05);
        color: #1591DC;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 16px 12px;
    }

    table tbody tr {
        border-bottom: 1px solid rgba(21, 145, 220, 0.1);
        transition: all 0.2s ease;
    }

    table tbody tr:hover {
        background-color: rgba(21, 145, 220, 0.04);
    }

    table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
    }

    .badge {
        font-weight: 700;
        padding: 6px 12px;
        font-size: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-radius: 8px;
    }

    .btn-sm {
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 14px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary {
        color: #1591DC;
        border-color: #1591DC;
        border-width: 1.5px;
    }

    .btn-outline-primary:hover {
        background-color: #1591DC;
        border-color: #1591DC;
        color: white;
        box-shadow: 0 4px 12px rgba(21, 145, 220, 0.3);
        transform: translateY(-2px);
    }

    .text-center h5 {
        font-weight: 700;
        color: #0a0e27;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .stat-card h3 {
            font-size: 24px !important;
        }

        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .nav-tabs .nav-link {
            padding: 10px 16px;
            font-size: 14px;
            white-space: nowrap;
        }
    }
</style>

@endsection
