@extends('frontend.layouts.main')

@section('main-content')

<section class="modern-hero">
    <div class="modern-hero-bg"></div>
    <div class="modern-blob modern-blob-1"></div>
    <div class="modern-blob modern-blob-2"></div>

    <div class="auto-container">
        <!-- Hero Text -->
        <h1 class="modern-h1">
            With a <span class="serif">strong</span> focus on building <span class="serif">practical</span> skills
        </h1>
        <p class="hero-subtitle">
            Join thousands of motivated learners mastering high-value technical skills with our structured, result-oriented courses.
        </p>

        <!-- Featured Component (Video/Image) -->
        <div class="modern-video-wrapper">
            <!-- Left Float -->
            <div class="float-content-left d-none d-xl-block">
                <div class="float-quote-box">
                    <p class="float-quote">" This an excellent platform for educators to monetize their skills "</p>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <h6 class="mb-0 small fw-bold">Kaito Tanaka</h6>
                    </div>
                    <a href="{{ route('product-lists') }}" class="modern-btn modern-btn-outline">Explore More</a>
                </div>
            </div>

            <!-- Main Video Card -->
            <div class="modern-video-card">
                <div class="video-container">
                    <img src="{{ asset('assets/images/about-student.png') }}" alt="Student Success Story">
                    
                    <!-- Top UI -->
                    <div class="video-ui-top-left">
                        <div class="video-avatar"><img src="{{ asset('assets/images/avatars.png') }}" style="object-fit: cover; object-position: 20% 0;"></div>
                        <div class="video-avatar"><img src="{{ asset('assets/images/avatars.png') }}" style="object-fit: cover; object-position: 40% 0;"></div>
                        <div class="video-avatar"><img src="{{ asset('assets/images/avatars.png') }}" style="object-fit: cover; object-position: 60% 0;"></div>
                    </div>

                    <div class="video-ui-top-right">
                        <div class="video-timer">24:12</div>
                    </div>

                    <!-- Bottom UI -->
                    <div class="video-ui-bottom">
                        <button class="video-control-btn"><i class="fas fa-microphone"></i></button>
                        <button class="video-control-btn"><i class="fas fa-video"></i></button>
                        <button class="video-control-btn end-call"><i class="fas fa-phone-alt"></i></button>
                        <button class="video-control-btn"><i class="fas fa-record-vinyl"></i></button>
                        <button class="video-control-btn"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
</section>

<section class="about-info pt-120 pb-120" style="background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);">
    <div class="auto-container">
        <div class="row align-items-center g-5">
            <!-- LEFT: Images -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="modern-img-wrapper" style="border-radius: 20px; overflow: hidden; box-shadow: 0 30px 80px rgba(21, 145, 220, 0.15); border: 2px solid rgba(21, 145, 220, 0.1);">
                    <img src="{{ asset('assets/images/about-student.png') }}" alt="About" class="w-100" style="display: block; transition: transform 0.4s ease;">
                </div>
            </div>

            <!-- RIGHT: Content -->
            <div class="col-xl-6 col-lg-6 col-md-12 ps-xl-5">
                <span class="modern-badge mb-3" style="font-size: 11px; font-weight: 700; color: #1591DC; background: rgba(21, 145, 220, 0.08); padding: 8px 14px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">{{ __('common.about_us') }}</span>
                <h2 class="modern-h2 mb-4" style="font-size: 36px; font-weight: 900; color: #0a0e27; line-height: 1.3;">{{ __('common.building_practical_skills') }}</h2>
                <p class="mb-5 text-muted" style="font-size: 15px; color: #666; font-weight: 500; line-height: 1.8;">{{ __('common.platform_overview') }}</p>

                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="d-flex align-items-start gap-3 p-4 rounded-3" style="background: white; border: 1px solid rgba(21, 145, 220, 0.12); transition: all 0.3s ease;">
                            <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0;">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold" style="font-size: 14px; color: #0a0e27;">{{ __('common.course_structure_focus') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start gap-3 p-4 rounded-3" style="background: white; border: 1px solid rgba(21, 145, 220, 0.12); transition: all 0.3s ease;">
                            <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold" style="font-size: 14px; color: #0a0e27;">{{ __('common.learner_support_all_levels') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="prduct-info pt-120 pb-120" style="background: #E8F1F9;">
    <div class="auto-container">
        <div class="text-center mb-5">
            <span class="modern-badge">{{ __('common.popular_courses') }}</span>
            <h2 class="modern-h2 mt-3">{{ __('common.choose_course') }}</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">{{ __('common.popular_courses_description') }}</p>
        </div>

        <div class="row g-4">
            @php $products = Helper::getRandomProduct(6); @endphp

            @foreach($products as $product)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="modern-course-card">
                        <div class="course-img-container">
                            @php $photo = explode(',', $product->photo); @endphp
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                            <div class="course-badge">{{ $product->cat_info->title ?? 'Technical' }}</div>
                        </div>
                        
                        <div class="course-content">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="course-rating-stars">
                                    <i class="fas fa-star text-warning small"></i>
                                    <i class="fas fa-star text-warning small"></i>
                                    <i class="fas fa-star text-warning small"></i>
                                    <i class="fas fa-star text-warning small"></i>
                                    <i class="fas fa-star text-warning small"></i>
                                </div>
                                <span class="small text-muted">(4.9)</span>
                            </div>

                            <h4 class="course-title"><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a></h4>
                            <p class="course-summary">{{ Str::limit($product->summary, 85) }}</p>
                            
                            <div class="course-footer">
                                <div class="course-price">
                                    {{ $product->getCurrencySymbol() }}{{ number_format($product->price, session('currency') == 'JPY' ? 0 : 2) }}
                                </div>
                                <a href="{{ route('product-detail', $product->slug) }}" class="course-enroll-link">
                                    Enroll Now <i class="fas fa-chevron-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('product-lists') }}" class="modern-btn modern-btn-outline">
                View All Courses <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="chse_secton pt-120 pb-120 bg-white">
    <div class="auto-container">
        <div class="text-center mb-5">
            <span class="modern-badge">{{ __('common.why_learn_with_us') }}</span>
            <h2 class="modern-h2">{{ __('common.structured_courses') }}</h2>
        </div>

        <div class="row g-4">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>{{ __('common.structured_courses') }}</h3>
                    <p class="text-muted">{{ __('common.structured_courses_description') }}</p>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>{{ __('common.industry_focused_content') }}</h3>
                    <p class="text-muted">{{ __('common.industry_focused_description') }}</p>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>{{ __('common.practical_learning') }}</h3>
                    <p class="text-muted">{{ __('common.practical_learning_description') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tech-hero-section">
    <video class="tech-hero-video" autoplay loop muted playsinline preload="auto" poster="{{ asset('assets/images/cta-bg-4.jpg') }}">
        <source src="{{ asset('assets/images/home-video.mp4') }}" type="video/mp4">
    </video>
    <div class="tech-hero-overlay"></div>
    <div class="tech-hero-container">
        <div class="tech-hero-glass-card">
            <div class="tech-hero-content">
                <h2>{{ __('common.unlimited_online_learning') }}</h2>
                <p>{{ __('common.unlimited_online_learning_description') }}</p>
                <a href="{{ route('product-lists') }}" class="modern-btn modern-btn-solid shadow-lg">
                    {{ __('common.know_more') }} <i class="fas fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- POINTS TOP UP SECTION - PREMIUM LUXURY DESIGN -->
<section class="points-topup-section pt-120 pb-120" id="topup">
    <div class="auto-container">
        <div class="text-center mb-5">
            <span class="modern-badge">POINTS TOP UP</span>
            <h2 class="modern-h2 mt-3">Maximize Your Value</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">
                Recharge your points and unlock exclusive bonuses instantly. Our tier-based system rewards you more as you grow.
            </p>
        </div>

        <div class="row align-items-center g-5">
            <!-- PREMIUM TIER CARDS -->
            <div class="col-xl-6 col-lg-6">
                <div class="premium-tier-section">
                    <!-- Section Header -->
                    <div class="tier-section-header">
                        <div class="header-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M16 2L20.123 12.038H30.879L22.378 17.962L26.501 28L16 22.076L5.499 28L9.622 17.962L1.121 12.038H11.877L16 2Z" fill="url(#tierGradient)"/>
                                <defs>
                                    <linearGradient id="tierGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#1591DC;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#2C5EAD;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <div class="header-text">
                            <h3 class="tier-title">Tier Rewards</h3>
                            <p class="tier-subtitle">Bigger purchases = bigger bonuses</p>
                        </div>
                    </div>

                    <!-- Tier Cards Grid -->
                    @if(session('currency') == 'JPY')
                    <div class="tier-cards-grid">
                        <!-- Tier 1 -->
                        <div class="tier-card tier-card-1">
                            <div class="tier-badge-large">1</div>
                            <h4 class="tier-card-label">Standard</h4>
                            <div class="tier-range-text">1 - 79,999 ¥</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text">×1</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 0%;"></div>
                            </div>
                        </div>

                        <!-- Tier 2 -->
                        <div class="tier-card tier-card-2">
                            <div class="tier-badge-large tier-badge-premium">2</div>
                            <h4 class="tier-card-label">Premium</h4>
                            <div class="tier-range-text">80,000 - 159,999 ¥</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×2</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 50%;"></div>
                            </div>
                        </div>

                        <!-- Tier 3 -->
                        <div class="tier-card tier-card-3">
                            <div class="tier-badge-large tier-badge-elite">3</div>
                            <h4 class="tier-card-label">Elite</h4>
                            <div class="tier-range-text">160,000 - 239,999 ¥</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×2.5</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 75%;"></div>
                            </div>
                        </div>

                        <!-- Tier 4 -->
                        <div class="tier-card tier-card-4">
                            <div class="tier-badge-large tier-badge-vip">4</div>
                            <h4 class="tier-card-label">VIP</h4>
                            <div class="tier-range-text">240,000+ ¥</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×3</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="currency-note">*160 JPY = 1 Credit</div>
                    @else
                    <div class="tier-cards-grid">
                        <!-- Tier 1 -->
                        <div class="tier-card tier-card-1">
                            <div class="tier-badge-large">1</div>
                            <h4 class="tier-card-label">Standard</h4>
                            <div class="tier-range-text">$1 - $499</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text">×1</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 0%;"></div>
                            </div>
                        </div>

                        <!-- Tier 2 -->
                        <div class="tier-card tier-card-2">
                            <div class="tier-badge-large tier-badge-premium">2</div>
                            <h4 class="tier-card-label">Premium</h4>
                            <div class="tier-range-text">$500 - $999</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×2</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 50%;"></div>
                            </div>
                        </div>

                        <!-- Tier 3 -->
                        <div class="tier-card tier-card-3">
                            <div class="tier-badge-large tier-badge-elite">3</div>
                            <h4 class="tier-card-label">Elite</h4>
                            <div class="tier-range-text">$1,000 - $1,499</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×2.5</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 75%;"></div>
                            </div>
                        </div>

                        <!-- Tier 4 -->
                        <div class="tier-card tier-card-4">
                            <div class="tier-badge-large tier-badge-vip">4</div>
                            <h4 class="tier-card-label">VIP</h4>
                            <div class="tier-range-text">$1,500+</div>
                            <div class="tier-multiplier">
                                <span class="multiplier-text multiplier-active">×3</span>
                                <span class="multiplier-label">Bonus</span>
                            </div>
                            <div class="tier-indicator-bar">
                                <div class="tier-indicator-fill" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="currency-note">*1 USD = 1 Credit</div>
                    @endif
                </div>
            </div>

            <!-- PREMIUM LUXURY CALCULATOR -->
            <div class="col-xl-6 col-lg-6">
                <div class="luxury-calculator-wrapper">
                    <!-- Decorative background elements -->
                    <div class="calc-bg-blob calc-blob-1"></div>
                    <div class="calc-bg-blob calc-blob-2"></div>

                    <div class="luxury-calculator">
                        <!-- Header -->
                        <div class="calc-header-premium">
                            <div class="calc-header-top">
                                <h2 class="calc-title-premium">Instant Recharge</h2>
                                <p class="calc-tagline">Get more points, faster</p>
                            </div>
                            <div class="calc-currency-badge">{{ session('currency') == 'JPY' ? '¥' : '$' }}</div>
                        </div>

                        <!-- Main Form -->
                        <form action="{{ route('points.add-to-cart') }}" method="POST" class="luxury-calc-form">
                            @csrf

                            <!-- Amount Input with Premium Styling -->
                            <div class="premium-input-section">
                                <label class="input-label-premium">How much would you like?</label>
                                <div class="premium-amount-input-wrapper">
                                    <input
                                        type="number"
                                        name="amount"
                                        id="topup_amount"
                                        class="premium-amount-input"
                                        placeholder="0"
                                        min="1"
                                        required
                                    >
                                    <span class="input-currency">{{ session('currency') == 'JPY' ? '¥' : '$' }}</span>
                                </div>
                            </div>

                            <!-- Points Breakdown Card -->
                            <div class="points-breakdown-card">
                                <div class="breakdown-row">
                                    <span class="breakdown-label">Base Points</span>
                                    <span class="breakdown-value" id="base_points">0</span>
                                </div>
                                <div class="breakdown-row">
                                    <span class="breakdown-label">Tier Bonus</span>
                                    <span class="breakdown-value bonus-badge" id="multiplier_display">×1</span>
                                </div>
                                <div class="breakdown-divider"></div>
                                <div class="breakdown-row breakdown-total">
                                    <span class="breakdown-label">You'll Get</span>
                                    <span class="breakdown-value-total" id="total_points">0</span>
                                </div>
                            </div>

                            <!-- Large Points Display -->
                            <div class="points-display-premium">
                                <span class="points-number" id="total_points_large">0</span>
                                <span class="points-unit">Points</span>
                            </div>

                            <!-- Benefits Checklist -->
                            <div class="benefits-section">
                                <div class="benefit-item">
                                    <i class="fas fa-bolt"></i>
                                    <span>Instant Credit</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>100% Secure</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-infinity"></i>
                                    <span>No Expiry</span>
                                </div>
                            </div>

                            <!-- Premium Button -->
                            <button type="submit" class="btn-premium-checkout">
                                <span class="btn-label">Add to Cart</span>
                                <span class="btn-icon"><i class="fas fa-arrow-right"></i></span>
                                <span class="btn-shine"></span>
                            </button>
                        </form>

                        <!-- Trust Badge -->
                        <div class="trust-indicator">
                            <i class="fas fa-check-circle"></i>
                            <span>Trusted by thousands of users</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* =========================================
       PREMIUM TIER CARDS - LUXURY DESIGN
       ========================================= */

    .premium-tier-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        box-shadow: 0 2px 8px rgba(21, 145, 220, 0.06);
        border: 1px solid rgba(21, 145, 220, 0.12);
    }

    /* Header */
    .tier-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .header-icon {
        width: 40px;
        height: 40px;
        background: rgba(21, 145, 220, 0.08);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tier-title {
        font-size: 20px;
        font-weight: 800;
        color: #0a0e27;
        margin: 0;
    }

    .tier-subtitle {
        font-size: 13px;
        color: #666;
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    /* Tier Cards Grid */
    .tier-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .tier-card {
        background: #f8fafc;
        border: 1px solid #e8eef8;
        border-radius: 12px;
        padding: 14px;
        position: relative;
    }

    .tier-badge-large {
        display: inline-flex;
        width: 32px;
        height: 32px;
        background: #f0f4ff;
        color: #1591DC;
        border-radius: 8px;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        border: none;
    }

    .tier-badge-premium {
        background: #f0f4ff;
    }

    .tier-badge-elite {
        background: #f0f4ff;
    }

    .tier-badge-vip {
        background: #f0f4ff;
    }

    .tier-card-label {
        font-size: 15px;
        font-weight: 700;
        color: #0a0e27;
        margin: 0 0 6px 0;
    }

    .tier-range-text {
        font-size: 12px;
        color: #666;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .tier-multiplier {
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin-bottom: 8px;
    }

    .multiplier-text {
        font-size: 18px;
        font-weight: 700;
        color: #666;
    }

    .multiplier-active {
        color: #1591DC;
        font-weight: 800;
    }

    .multiplier-label {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
    }

    .tier-indicator-bar {
        width: 100%;
        height: 3px;
        background: #e8eef8;
        border-radius: 2px;
        overflow: hidden;
    }

    .tier-indicator-fill {
        height: 100%;
        background: #1591DC;
    }

    .currency-note {
        font-size: 12px;
        color: #1591DC;
        background: rgba(21, 145, 220, 0.06);
        padding: 10px 14px;
        border-radius: 8px;
        display: inline-block;
        font-weight: 600;
    }

    /* =========================================
       LUXURY CALCULATOR - PREMIUM DESIGN
       ========================================= */

    .luxury-calculator-wrapper {
        position: relative;
        height: 100%;
    }

    .calc-bg-blob {
        display: none;
    }

    .luxury-calculator {
        background: #ffffff;
        border: 1px solid rgba(21, 145, 220, 0.12);
        border-radius: 20px;
        padding: 28px 32px;
        box-shadow: 0 2px 8px rgba(21, 145, 220, 0.06);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Calculator Header */
    .calc-header-premium {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .calc-title-premium {
        font-size: 20px;
        font-weight: 800;
        color: #0a0e27;
        margin: 0 0 4px 0;
    }

    .calc-tagline {
        font-size: 13px;
        color: #666;
        margin: 0;
        font-weight: 500;
    }

    .calc-currency-badge {
        width: 40px;
        height: 40px;
        background: #1591DC;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        box-shadow: none;
    }

    /* Form Styling */
    .luxury-calc-form {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .premium-input-section {
        margin-bottom: 16px;
    }

    .input-label-premium {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
    }

    .premium-amount-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .premium-amount-input {
        width: 100%;
        font-size: 32px;
        font-weight: 800;
        color: #0a0e27;
        background: transparent;
        border: none;
        border-bottom: 2px solid #e8eef8;
        padding: 10px 0;
        outline: none;
        letter-spacing: -0.5px;
    }

    .premium-amount-input:focus {
        border-bottom-color: #1591DC;
    }

    .input-currency {
        position: absolute;
        right: 18px;
        font-size: 24px;
        font-weight: 700;
        color: #1591DC;
        opacity: 0.6;
    }

    /* Points Breakdown */
    .points-breakdown-card {
        background: #f8fafc;
        border: 1px solid #e8eef8;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
    }

    .breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 12px;
    }

    .breakdown-row.breakdown-total {
        margin-bottom: 0;
    }

    .breakdown-label {
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .breakdown-value {
        font-weight: 700;
        color: #0a0e27;
        font-size: 13px;
    }

    .bonus-badge {
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .breakdown-divider {
        height: 1px;
        background: #e8eef8;
        margin: 8px 0;
    }

    .breakdown-value-total {
        font-size: 16px;
        font-weight: 800;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Large Points Display */
    .points-display-premium {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-bottom: 16px;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px dashed #e8eef8;
    }

    .points-number {
        font-size: 32px;
        font-weight: 900;
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -1px;
    }

    .points-unit {
        font-size: 11px;
        color: #666;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Benefits */
    .benefits-section {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
    }

    .benefit-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e8eef8;
    }

    .benefit-item i {
        font-size: 14px;
        color: #1591DC;
    }

    .benefit-item span {
        font-size: 10px;
        color: #666;
        font-weight: 500;
        text-align: center;
    }

    /* Premium Button */
    .btn-premium-checkout {
        width: 100%;
        padding: 12px 20px;
        background: #1591DC;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(21, 145, 220, 0.3);
        transition: background 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 12px;
    }

    .btn-premium-checkout:hover {
        background: #0e7ab8;
        box-shadow: 0 4px 12px rgba(21, 145, 220, 0.4);
    }

    .btn-premium-checkout:active {
        transform: scale(0.98);
    }

    .btn-label {
        font-weight: 600;
    }

    .btn-icon {
        display: none;
    }

    .btn-shine {
        display: none;
    }

    /* Trust Badge */
    .trust-indicator {
        text-align: center;
        font-size: 11px;
        color: #888;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .trust-indicator i {
        color: #1591DC;
        font-size: 12px;
    }

    /* =========================================
       RESPONSIVE DESIGN
       ========================================= */

    @media (max-width: 768px) {
        .premium-tier-section,
        .luxury-calculator {
            padding: 24px 20px;
        }

        .calc-title-premium {
            font-size: 16px;
        }

        .premium-amount-input {
            font-size: 24px;
        }

        .points-number {
            font-size: 32px;
        }

        .tier-title {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .premium-tier-section,
        .luxury-calculator {
            padding: 20px 16px;
        }

        .tier-section-header {
            gap: 10px;
            margin-bottom: 16px;
        }

        .header-icon {
            width: 36px;
            height: 36px;
        }

        .tier-title {
            font-size: 16px;
        }

        .tier-subtitle {
            font-size: 11px;
        }

        .calc-title-premium {
            font-size: 15px;
        }

        .calc-tagline {
            font-size: 11px;
        }

        .premium-amount-input {
            font-size: 22px;
        }

        .points-number {
            font-size: 30px;
        }

        .tier-cards-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .tier-card {
            padding: 12px;
        }

        .btn-premium-checkout {
            padding: 10px 16px;
            font-size: 13px;
        }

        .calc-header-premium {
            flex-direction: column;
            gap: 10px;
        }

        .calc-currency-badge {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }
    }
</style>

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

            basePointsDisplay.textContent = basePoints.toLocaleString();
            multiplierDisplay.textContent = '×' + multiplier.toFixed(1);
            totalPointsDisplay.textContent = totalPoints.toLocaleString();
            totalPointsLarge.textContent = totalPoints.toLocaleString();
        }

        amountInput.addEventListener('input', calculatePoints);
        amountInput.addEventListener('change', calculatePoints);
    });
</script>

@endsection
