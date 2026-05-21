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

            <!-- Right Float -->
            <div class="float-content-right d-none d-xl-block">
                <div class="float-stat-box">
                    <div class="mb-4">
                        <div class="d-flex justify-content-center mb-3">
                             <div class="video-avatar"><img src="{{ asset('assets/images/avatars.png') }}" style="object-fit: cover; object-position: 80% 0;"></div>
                             <div class="video-avatar"><img src="{{ asset('assets/images/avatars.png') }}" style="object-fit: cover; object-position: 100% 0;"></div>
                        </div>
                        <h2 class="float-stat">25K</h2>
                        <p class="float-stat-label">SATISFIED USERS</p>
                    </div>
                    <div class="pt-4 border-top">
                        <p class="fw-bold text-dark small">We are chosen for our quality</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-info pt-120 pb-120 bg-white">
    <div class="auto-container">
        <div class="row align-items-center">
            <!-- LEFT: Images -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="modern-img-wrapper" style="box-shadow: 0 30px 60px rgba(0,0,0,0.08);">
                    <img src="{{ asset('assets/images/about-student.png') }}" alt="About" class="w-100">
                </div>
            </div>

            <!-- RIGHT: Content -->
            <div class="col-xl-6 col-lg-6 col-md-12 ps-xl-5">
                <span class="modern-badge">{{ __('common.about_us') }}</span>
                <h2 class="modern-h2 mb-4">{{ __('common.building_practical_skills') }}</h2>
                <p class="mb-4 text-muted">{{ __('common.platform_overview') }}</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0"><i class="fas fa-check"></i></div>
                            <p class="mb-0 fw-bold">{{ __('common.course_structure_focus') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0"><i class="fas fa-check"></i></div>
                            <p class="mb-0 fw-bold">{{ __('common.learner_support_all_levels') }}</p>
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

<!-- POINTS TOP UP SECTION -->
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
            <!-- Left: Tier Table -->
            <div class="col-xl-6 col-lg-6">
                <div style="padding: 20px; background: var(--white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md);">
                @if(session('currency') == 'JPY')
                    <p class="text-muted small mb-4" style="font-weight: 600;">💡 *160 JPY = 1 Credit</p>
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
                    <p class="text-muted small mb-4" style="font-weight: 600;">💡 *1 USD = 1 Credit</p>
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
                <div class="calculator-card">
                    <h3 class="mb-5">💰 Recharge Now</h3>
                    
                    <form action="{{ route('points.add-to-cart') }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="calc-label">Enter Amount ({{ session('currency') == 'JPY' ? '¥' : '$' }})</label>
                            <div class="calc-input-group">
                                <input type="number" name="amount" id="topup_amount" class="calc-input" placeholder="0.00" min="1" required>
                            </div>
                        </div>

                        <div class="mb-5 text-center">
                            <label class="calc-label mb-3">📊 Estimated Total Points</label>
                            <div class="points-display-val" id="total_points">0</div>
                        </div>

                        <button type="submit" class="modern-btn modern-btn-solid w-100 py-4 shadow-lg">
                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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

<section class="categ-winfo pt-120 pb-120">
    <div class="auto-container">
        <div class="text-center mb-5">
            <span class="modern-badge">{{ __('common.browse_categories') }}</span>
            <h2 class="modern-h2 mt-3">{{ __('common.top_learning_areas') }}</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">{{ __('common.top_learning_areas_description') }}</p>
        </div>

        @php
            $categories = Helper::productCategoryList("all");
            $images = ['1.webp', '2.webp', '3.webp', '4.webp', '5.webp'];
        @endphp

        <div class="row g-4">
            <!-- Left: Hero Category -->
            @if(isset($categories[0]))
            <div class="col-xl-6 col-lg-6">
                <div class="modern-category-card h-100" style="min-height: 500px;">
                    <a href="{{ route('product-cat', $categories[0]->slug) }}" class="d-block h-100">
                        <img src="{{ asset('assets/images/' . ($images[0] ?? 'service-1.jpg')) }}" alt="{{ $categories[0]->title }}">
                        <div class="category-overlay">
                            <span class="category-count">Featured Path</span>
                            <h4 class="category-name" style="font-size: 32px;">{{ $categories[0]->title }}</h4>
                        </div>
                        <div class="category-btn" style="width: 70px; height: 70px; font-size: 24px;">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endif

            <!-- Right: Smaller Categories Grid -->
            <div class="col-xl-6 col-lg-6">
                <div class="row g-4">
                    @foreach($categories->slice(1, 4) as $index => $cat_info)
                        <div class="col-md-6">
                            <div class="modern-category-card" style="height: 240px;">
                                <a href="{{ route('product-cat', $cat_info->slug) }}" class="d-block h-100">
                                    <img src="{{ asset('assets/images/' . ($images[$index+1] ?? 'service-1.jpg')) }}" alt="{{ $cat_info->title }}">
                                    <div class="category-overlay p-3">
                                        <h4 class="category-name" style="font-size: 18px;">{{ $cat_info->title }}</h4>
                                    </div>
                                    <div class="category-btn" style="width: 40px; height: 40px; font-size: 14px; top: 20px; right: 20px;">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- Explore More Tile -->
                    <div class="col-md-6">
                        <div class="modern-category-card d-flex align-items-center justify-content-center bg-dark text-white" style="height: 240px; background: linear-gradient(135deg, #2C5EAD 0%, #1591DC 100%);">
                            <div class="text-center p-4">
                                <h4 class="text-white mb-3">Many More</h4>
                                <p class="small opacity-75 mb-4">Discover our full range of professional learning paths.</p>
                                <a href="{{ route('product-lists') }}" class="modern-btn modern-btn-outline border-white text-white py-2 px-4" style="font-size: 12px;">
                                    View All <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
