@extends('frontend.layouts.main')

@section('title', 'Top Up Points - Rise Beyond Growth')

@section('main-content')
<div class="tl-breadcrumb catalog-banner pt-120 pb-120">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>
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
                <div class="bonus-multipliers-card">
                    <div class="bonus-header">
                        <div class="bonus-icon-wrapper">
                            <i class="fas fa-star-of-life"></i>
                        </div>
                        <div class="bonus-title-group">
                            <h4 class="bonus-title">Bonus Multipliers</h4>
                            <p class="bonus-subtitle">Earn more with every tier</p>
                        </div>
                    </div>

                    @if(session('currency') == 'JPY')
                    <div class="bonus-note">*160 JPY = 1 Credit</div>
                    <div class="tiers-grid">
                        <!-- Tier 1 -->
                        <div class="tier-card tier-1">
                            <div class="tier-badge">Tier 1</div>
                            <div class="tier-range">1 - 79,999 ¥</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value">None</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Tier 2 -->
                        <div class="tier-card tier-2">
                            <div class="tier-badge premium">Premium</div>
                            <div class="tier-range">80,000 - 159,999 ¥</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×2</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                        </div>

                        <!-- Tier 3 -->
                        <div class="tier-card tier-3">
                            <div class="tier-badge elite">Elite</div>
                            <div class="tier-range">160,000 - 239,999 ¥</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×2.5</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- Tier 4 -->
                        <div class="tier-card tier-4">
                            <div class="tier-badge vip">VIP</div>
                            <div class="tier-range">240,000+ ¥</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×3</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bonus-note">*1 USD = 1 Credit</div>
                    <div class="tiers-grid">
                        <!-- Tier 1 -->
                        <div class="tier-card tier-1">
                            <div class="tier-badge">Tier 1</div>
                            <div class="tier-range">$1 - $499</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value">None</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Tier 2 -->
                        <div class="tier-card tier-2">
                            <div class="tier-badge premium">Premium</div>
                            <div class="tier-range">$500 - $999</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×2</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                        </div>

                        <!-- Tier 3 -->
                        <div class="tier-card tier-3">
                            <div class="tier-badge elite">Elite</div>
                            <div class="tier-range">$1,000 - $1,499</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×2.5</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- Tier 4 -->
                        <div class="tier-card tier-4">
                            <div class="tier-badge vip">VIP</div>
                            <div class="tier-range">$1,500+</div>
                            <div class="tier-bonus">
                                <span class="bonus-label">Bonus</span>
                                <span class="bonus-value bonus-multiplier">×3</span>
                            </div>
                            <div class="tier-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Recharge Calculator -->
            <div class="col-xl-6 col-lg-6">
                <div class="recharge-calculator">
                    <div class="calculator-glow"></div>

                    <div class="calculator-content">
                        <div class="calculator-header">
                            <h3 class="calculator-title">Recharge Now</h3>
                            <p class="calculator-subtitle">Instant points. Instant rewards.</p>
                        </div>

                        <form action="{{ route('points.add-to-cart') }}" method="POST" class="recharge-form">
                            @csrf

                            <!-- Amount Input -->
                            <div class="calc-input-wrapper">
                                <label class="calc-input-label">
                                    <span class="label-text">Amount to Add</span>
                                    <span class="currency-symbol">{{ session('currency') == 'JPY' ? '¥' : '$' }}</span>
                                </label>
                                <div class="calc-input-field">
                                    <input
                                        type="number"
                                        name="amount"
                                        id="topup_amount"
                                        class="calc-number-input"
                                        placeholder="0"
                                        min="1"
                                        required
                                    >
                                    <div class="input-focus-line"></div>
                                </div>
                            </div>

                            <!-- Points Calculation Display -->
                            <div class="points-calculation-section">
                                <div class="calculation-row">
                                    <span class="calc-label">Base Points</span>
                                    <span class="calc-value" id="base_points">0</span>
                                </div>
                                <div class="calculation-row">
                                    <span class="calc-label">Multiplier Bonus</span>
                                    <span class="calc-value multiplier-badge" id="multiplier_display">×1.0</span>
                                </div>
                                <div class="calculation-divider"></div>
                                <div class="calculation-row total">
                                    <span class="calc-label">Total Points You'll Get</span>
                                    <span class="calc-value total-value" id="total_points">0</span>
                                </div>
                            </div>

                            <!-- Visual Points Display -->
                            <div class="points-display-container">
                                <div class="points-large-display">
                                    <span id="total_points_large">0</span>
                                    <span class="points-label">PTS</span>
                                </div>
                            </div>

                            <!-- Features List -->
                            <div class="features-list">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Instant delivery</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-lock"></i>
                                    <span>Secure payment</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-redo"></i>
                                    <span>No expiration</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="recharge-submit-btn">
                                <span class="btn-icon"><i class="fas fa-shopping-cart"></i></span>
                                <span class="btn-text">Add to Cart</span>
                                <span class="btn-arrow"><i class="fas fa-arrow-right"></i></span>
                            </button>
                        </form>
                    </div>
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
    /* ============================================
       BONUS MULTIPLIERS - PREMIUM CARD DESIGN
       ============================================ */

    .bonus-multipliers-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(21, 145, 220, 0.08);
        border: 1px solid rgba(21, 145, 220, 0.1);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(10px);
    }

    .bonus-multipliers-card:hover {
        box-shadow: 0 16px 48px rgba(21, 145, 220, 0.15);
        transform: translateY(-2px);
    }

    .bonus-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
    }

    .bonus-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(21, 145, 220, 0.25);
    }

    .bonus-title-group h4 {
        font-size: 22px;
        font-weight: 800;
        color: #111;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .bonus-subtitle {
        font-size: 13px;
        color: #888;
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    .bonus-note {
        font-size: 12px;
        color: #1591DC;
        font-weight: 600;
        margin-bottom: 24px;
        padding: 8px 12px;
        background: rgba(21, 145, 220, 0.06);
        border-radius: 8px;
        display: inline-block;
    }

    .tiers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
    }

    .tier-card {
        background: #f8f9fb;
        border: 2px solid #e8eef8;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .tier-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #1591DC 0%, #2C5EAD 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .tier-card:hover {
        border-color: #1591DC;
        background: linear-gradient(135deg, rgba(21, 145, 220, 0.04) 0%, rgba(44, 94, 173, 0.02) 100%);
    }

    .tier-card:hover::before {
        transform: scaleX(1);
    }

    .tier-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        background: #e8eef8;
        color: #2C5EAD;
        border-radius: 6px;
        margin-bottom: 12px;
        letter-spacing: 0.5px;
    }

    .tier-badge.premium {
        background: rgba(21, 145, 220, 0.15);
        color: #1591DC;
    }

    .tier-badge.elite {
        background: rgba(21, 145, 220, 0.2);
        color: #0066B2;
    }

    .tier-badge.vip {
        background: linear-gradient(135deg, rgba(21, 145, 220, 0.25), rgba(44, 94, 173, 0.15));
        color: #0066B2;
    }

    .tier-range {
        font-size: 13px;
        font-weight: 700;
        color: #222;
        margin-bottom: 12px;
    }

    .tier-bonus {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(21, 145, 220, 0.1);
    }

    .bonus-label {
        font-size: 11px;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
    }

    .bonus-value {
        font-size: 14px;
        font-weight: 700;
        color: #888;
    }

    .bonus-multiplier {
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 16px;
    }

    .tier-progress {
        width: 100%;
        height: 3px;
        background: #e8eef8;
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #1591DC 0%, #2C5EAD 100%);
        border-radius: 2px;
        transition: width 0.4s ease;
    }

    /* ============================================
       RECHARGE CALCULATOR - PREMIUM DESIGN
       ============================================ */

    .recharge-calculator {
        position: relative;
        height: 100%;
    }

    .calculator-glow {
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(21, 145, 220, 0.15) 0%, transparent 70%);
        pointer-events: none;
        animation: glow-pulse 8s ease-in-out infinite;
    }

    @keyframes glow-pulse {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    .calculator-content {
        position: relative;
        z-index: 2;
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border: 2px solid rgba(21, 145, 220, 0.15);
        border-radius: 24px;
        padding: 40px;
        backdrop-filter: blur(20px);
        box-shadow: 0 20px 60px rgba(21, 145, 220, 0.1);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .calculator-content:hover {
        box-shadow: 0 30px 80px rgba(21, 145, 220, 0.15);
        border-color: rgba(21, 145, 220, 0.25);
    }

    .calculator-header {
        margin-bottom: 32px;
    }

    .calculator-title {
        font-size: 28px;
        font-weight: 800;
        color: #111;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .calculator-subtitle {
        font-size: 14px;
        color: #888;
        margin: 8px 0 0 0;
        font-weight: 500;
    }

    .recharge-form {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .calc-input-wrapper {
        margin-bottom: 28px;
    }

    .calc-input-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        cursor: text;
    }

    .label-text {
        font-size: 13px;
        font-weight: 700;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .currency-symbol {
        font-size: 14px;
        font-weight: 700;
        color: #1591DC;
        background: rgba(21, 145, 220, 0.1);
        padding: 4px 10px;
        border-radius: 6px;
    }

    .calc-input-field {
        position: relative;
    }

    .calc-number-input {
        width: 100%;
        font-size: 36px;
        font-weight: 800;
        color: #111;
        background: transparent;
        border: none;
        border-bottom: 2px solid #e8eef8;
        padding: 12px 0 8px 0;
        text-align: center;
        transition: all 0.3s ease;
        outline: none;
        letter-spacing: -1px;
    }

    .calc-number-input:focus {
        border-bottom-color: #1591DC;
    }

    .input-focus-line {
        position: absolute;
        bottom: -2px;
        left: 0;
        height: 2px;
        background: linear-gradient(90deg, #1591DC 0%, #2C5EAD 100%);
        width: 0;
        transition: width 0.3s ease;
    }

    .calc-number-input:focus ~ .input-focus-line {
        width: 100%;
    }

    /* Calculation Display */
    .points-calculation-section {
        background: #f8f9fb;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e8eef8;
    }

    .calculation-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .calculation-row.total {
        margin-bottom: 0;
    }

    .calc-label {
        color: #888;
        font-weight: 600;
    }

    .calc-value {
        font-weight: 700;
        color: #444;
    }

    .multiplier-badge {
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 14px;
    }

    .calculation-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #1591DC 50%, transparent 100%);
        margin: 12px 0;
    }

    .calculation-row.total .calc-label {
        color: #111;
        font-weight: 700;
    }

    .calculation-row.total .total-value {
        font-size: 18px;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Large Points Display */
    .points-display-container {
        text-align: center;
        margin-bottom: 28px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(21, 145, 220, 0.05) 0%, rgba(44, 94, 173, 0.02) 100%);
        border-radius: 16px;
        border: 2px dashed rgba(21, 145, 220, 0.2);
    }

    .points-large-display {
        display: flex;
        align-items: baseline;
        justify-content: center;
        gap: 8px;
    }

    #total_points_large {
        font-size: 48px;
        font-weight: 900;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -2px;
    }

    .points-label {
        font-size: 16px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Features List */
    .features-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 28px;
        padding: 16px 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }

    .feature-item i {
        color: #1591DC;
        font-size: 14px;
    }

    /* Submit Button */
    .recharge-submit-btn {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(21, 145, 220, 0.3);
        letter-spacing: 0.5px;
        margin-top: auto;
    }

    .recharge-submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .recharge-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(21, 145, 220, 0.4);
    }

    .recharge-submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .recharge-submit-btn:active {
        transform: translateY(0);
    }

    .btn-icon {
        display: flex;
        align-items: center;
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .recharge-submit-btn:hover .btn-icon {
        transform: scale(1.1);
    }

    .btn-text {
        font-weight: 700;
    }

    .btn-arrow {
        opacity: 0;
        transform: translateX(-8px);
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .recharge-submit-btn:hover .btn-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    /* Bundle Cards Styling */
    .transition-up {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .transition-up:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px -12px rgba(50,50,93,0.15) !important;
    }
    .fw-900 { font-weight: 900; }
    .tiny { font-size: 0.7rem; }

    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */

    @media (max-width: 768px) {
        .bonus-multipliers-card,
        .calculator-content {
            padding: 28px 20px;
        }

        .calculator-title {
            font-size: 24px;
        }

        .calc-number-input {
            font-size: 28px;
        }

        #total_points_large {
            font-size: 36px;
        }

        .bonus-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .tiers-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .bonus-multipliers-card,
        .calculator-content {
            padding: 20px 16px;
        }

        .calculator-title {
            font-size: 20px;
        }

        .calc-number-input {
            font-size: 24px;
        }

        #total_points_large {
            font-size: 32px;
        }

        .tiers-grid {
            grid-template-columns: 1fr;
        }

        .recharge-submit-btn {
            flex-direction: column;
            gap: 8px;
        }

        .btn-arrow {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('topup_amount');
        const totalPointsDisplay = document.getElementById('total_points');
        const totalPointsLarge = document.getElementById('total_points_large');
        const basePointsDisplay = document.getElementById('base_points');
        const multiplierDisplay = document.getElementById('multiplier_display');

        function calculatePoints() {
            const amount = parseFloat(amountInput.value) || 0;
            let multiplier = 1;
            const isJPY = {{ session('currency') == 'JPY' ? 'true' : 'false' }};

            let basePoints = 0;

            if (isJPY) {
                basePoints = Math.floor(amount / 160);

                if (amount >= 240000) multiplier = 3;
                else if (amount >= 160000) multiplier = 2.5;
                else if (amount >= 80000) multiplier = 2;
            } else {
                basePoints = Math.floor(amount);

                if (amount >= 1500) multiplier = 3;
                else if (amount >= 1000) multiplier = 2.5;
                else if (amount >= 500) multiplier = 2;
            }

            const totalPoints = Math.round(basePoints * multiplier);

            // Update displays with animation
            basePointsDisplay.textContent = basePoints.toLocaleString();
            multiplierDisplay.textContent = '×' + multiplier.toFixed(1);
            totalPointsDisplay.textContent = totalPoints.toLocaleString();
            totalPointsLarge.textContent = totalPoints.toLocaleString();
        }

        amountInput.addEventListener('input', calculatePoints);
        amountInput.addEventListener('change', calculatePoints);
    });
</script>
@endpush
