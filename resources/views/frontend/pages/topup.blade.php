@extends('frontend.layouts.main')

@section('title', 'Top Up Points - Rise Beyond Growth')

@section('main-content')
<div class="tl-breadcrumb catalog-banner pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">Elevate Your Learning</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="{{route('home')}}">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>Top Up Points</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="topup-section pt-120 pb-120 bg-light">
    <div class="container">
        <div class="text-center mb-5 pb-4">
            <span class="modern-badge">POINTS TOP UP</span>
            <h2 class="modern-h2 mt-3">Maximize Your Value</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Unlock premium courses and elite training sessions. Our tier-based system rewards you more as you grow.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger border-0 rounded-4 shadow-sm p-4 mb-5 d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                <div class="fw-bold">{{ session('error') }}</div>
            </div>
        @endif

        <div class="row align-items-center g-5 mb-5">
            <!-- Left: Tier Table -->
            <div class="col-xl-6 col-lg-6">
                <div class="p-4 rounded-5 bg-white shadow-sm" style="border-radius: 40px;">
                    <h4 class="fw-800 text-dark mb-2 px-3">Bonus Multipliers</h4>
                    @if(session('currency') == 'JPY')
                        <p class="text-muted small px-3 mb-4">*160 JPY = 1 Credit</p>
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>JPY Range</th>
                                        <th>Bonus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1 - 79,999</td>
                                        <td><span class="badge bg-light text-dark px-3 py-2 rounded-pill">None</span></td>
                                    </tr>
                                    <tr>
                                        <td>80,000 - 159,999</td>
                                        <td><span class="badge bg-primary px-3 py-2 rounded-pill">x 2</span></td>
                                    </tr>
                                    <tr>
                                        <td>160,000 - 239,999</td>
                                        <td><span class="badge bg-primary px-3 py-2 rounded-pill">x 2.5</span></td>
                                    </tr>
                                    <tr>
                                        <td>240,000 and above</td>
                                        <td><span class="badge bg-success px-3 py-2 rounded-pill">x 3</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted small px-3 mb-4">*1 USD = 1 Credit</p>
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>USD Range</th>
                                        <th>Bonus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>$1 - $499</td>
                                        <td><span class="badge bg-light text-dark px-3 py-2 rounded-pill">None</span></td>
                                    </tr>
                                    <tr>
                                        <td>$500 - $999</td>
                                        <td><span class="badge bg-primary px-3 py-2 rounded-pill">x 2</span></td>
                                    </tr>
                                    <tr>
                                        <td>$1,000 - $1,499</td>
                                        <td><span class="badge bg-primary px-3 py-2 rounded-pill">x 2.5</span></td>
                                    </tr>
                                    <tr>
                                        <td>$1,500 and above</td>
                                        <td><span class="badge bg-success px-3 py-2 rounded-pill">x 3</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Calculator -->
            <div class="col-xl-6 col-lg-6">
                <div class="calculator-card p-5 shadow-lg">
                    <h3 class="mb-5 text-white">Recharge Now</h3>
                    
                    <form action="{{ route('points.add-to-cart') }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="calc-label">Enter Amount ({{ session('currency') == 'JPY' ? '¥' : '$' }})</label>
                            <div class="calc-input-group">
                                <input type="number" name="amount" id="topup_amount" class="calc-input" placeholder="0.00" min="1" required>
                            </div>
                        </div>

                        <div class="mb-5 text-center">
                            <label class="calc-label mb-3">Estimated Total Points</label>
                            <div class="points-display-val" id="total_points" style="font-size: 64px; font-weight: 900; color: #fff;">0</div>
                        </div>

                        <button type="submit" class="modern-btn modern-btn-solid w-100 py-4 shadow-lg">
                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-5">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-800 text-dark">Pre-defined Bundles</h3>
            </div>
            @foreach($bundles as $bundle)
            <div class="col-lg-3 col-md-6">
                <div class="modern-card p-4 border-0 shadow-lg bg-white h-100 transition-up" style="border-radius: 35px;">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="bundle-icon bg-soft-primary p-3 rounded-4" style="background: rgba(21, 145, 220, 0.08);">
                            <i class="fas fa-coins text-primary fs-4"></i>
                        </div>
                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 tiny fw-bold">LEVEL {{ $loop->iteration }}</span>
                    </div>
                    
                    <h4 class="fw-800 text-dark mb-2">{{ $bundle['title'] }}</h4>
                    <div class="points-badge mb-4">
                        <span class="fs-1 fw-900 text-primary" style="font-weight: 900;">{{ number_format($bundle['points']) }}</span>
                        <span class="text-muted small fw-bold ms-1">PTS</span>
                    </div>
                    
                    <p class="text-muted small mb-5 lh-lg">{{ $bundle['description'] }}</p>
                    
                    <form action="{{route('points.add-to-cart')}}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ session('currency') == 'JPY' ? $bundle['price'] * 160 : $bundle['price'] }}">
                        <button type="submit" class="modern-btn modern-btn-solid w-100 py-3 rounded-pill shadow-sm">
                            Buy for {{ session('currency') == 'JPY' ? '¥' . number_format($bundle['price'] * 160) : '$' . number_format($bundle['price']) }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .transition-up {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .transition-up:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px -12px rgba(50,50,93,0.15) !important;
    }
    .fw-900 { font-weight: 900; }
    .tiny { font-size: 0.7rem; }
    
    /* Ensure calculator styles are inherited if not in main CSS */
    .calculator-card {
        background: #111;
        border-radius: 40px;
        position: relative;
        overflow: hidden;
    }
    .calc-label {
        color: rgba(255,255,255,0.6);
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
    }
    .calc-input {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(255,255,255,0.1);
        color: #fff;
        font-size: 32px;
        font-weight: 700;
        width: 100%;
        padding: 15px 0;
        text-align: center;
        transition: all 0.3s ease;
    }
    .calc-input:focus {
        outline: none;
        border-bottom-color: var(--primary-color, #6366f1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('topup_amount');
        const totalPointsDisp = document.getElementById('total_points');

        amountInput.addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            let multiplier = 1;
            const isJPY = {{ session('currency') == 'JPY' ? 'true' : 'false' }};

            if (isJPY) {
                if (amount >= 240000) multiplier = 3;
                else if (amount >= 160000) multiplier = 2.5;
                else if (amount >= 80000) multiplier = 2;

                const totalPoints = Math.round((amount / 160) * multiplier);
                totalPointsDisp.innerText = totalPoints.toLocaleString();
            } else {
                if (amount >= 1500) multiplier = 3;
                else if (amount >= 1000) multiplier = 2.5;
                else if (amount >= 500) multiplier = 2;

                const totalPoints = Math.round(amount * multiplier);
                totalPointsDisp.innerText = totalPoints.toLocaleString();
            }
        });
    });
</script>
@endpush
