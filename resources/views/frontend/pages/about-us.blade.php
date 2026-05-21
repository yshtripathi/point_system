@extends('frontend.layouts.main') 
@section('title','About Us')
@section('main-content')

<div class="tl-breadcrumb pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.about') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.about') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="about-page-section pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left: Images -->
            <div class="col-xl-6 col-lg-6">
                <div class="modern-img-wrapper">
                    <img src="{{ asset('assets/images/about-student.png') }}" alt="About Us" class="w-100 rounded-4 shadow-lg">
                </div>
            </div>

            <!-- Right: Content -->
            <div class="col-xl-6 col-lg-6 ps-xl-5">
                <span class="modern-badge mb-3">{{__('common.get_to_know_us')}}</span>
                <h2 class="modern-h2 mb-4">{{__('common.build_skills_anywhere')}}</h2>
                <p class="text-muted lead mb-5">
                    At {{ $misc['Company Name'] ?? __('common.company_name') }}, we are committed to bridging the gap between theory and practice. Our platform provides the tools and guidance needed to excel in today's competitive landscape.
                </p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0 shadow-sm"><i class="fas fa-graduation-cap"></i></div>
                            <h6 class="mb-0 fw-bold">{{ __('common.built_for_modern_learning') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0 shadow-sm"><i class="fas fa-user-tie"></i></div>
                            <h6 class="mb-0 fw-bold">{{ __('common.expert_led_content') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0 shadow-sm"><i class="fas fa-laptop-code"></i></div>
                            <h6 class="mb-0 fw-bold">{{ __('common.practical_skill_focused_courses') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="modern-cart-btn bg-light text-primary border-0 shadow-sm"><i class="fas fa-clock"></i></div>
                            <h6 class="mb-0 fw-bold">{{ __('common.flexible_learning_access') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="values-section pt-120 pb-120 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="modern-badge">{{ __('common.why_learn_with_us') }}</span>
            <h2 class="modern-h2 mt-3">{{ __('common.structured_courses') }}</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px;">{{ __('common.why_learn_description') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center p-5 h-100">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 70px; height: 70px; font-size: 28px;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h4>{{ __('common.structured_courses') }}</h4>
                    <p class="text-muted mt-3 mb-0">{{ __('common.structured_courses_description') }}</p>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center p-5 h-100">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 70px; height: 70px; font-size: 28px;">
                        <i class="fas fa-globe-americas"></i>
                    </div>
                    <h4>{{ __('common.industry_focused_content') }}</h4>
                    <p class="text-muted mt-3 mb-0">{{ __('common.industry_focused_description') }}</p>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="modern-card text-center p-5 h-100">
                    <div class="modern-cart-btn mx-auto mb-4 bg-primary text-white" style="width: 70px; height: 70px; font-size: 28px;">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h4>{{ __('common.practical_learning') }}</h4>
                    <p class="text-muted mt-3 mb-0">{{ __('common.practical_learning_description') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
