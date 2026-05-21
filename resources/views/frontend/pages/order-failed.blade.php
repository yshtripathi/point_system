@extends('frontend.layouts.main')
@section('title', 'Payment Failed')
@section('main-content')

<div class="tl-breadcrumb about-banner pt-120 pb-120">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.payment_unsuccessful') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>Failed</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="failed-section pt-120 pb-120 bg-light">  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center">
                <div class="modern-card p-5 border-0 shadow-lg bg-white" style="border-radius: 40px;">
                    <div class="failed-icon-container mb-5">
                        <div class="rounded-circle bg-soft-danger d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px; background: rgba(239, 68, 68, 0.1);">
                            <i class="fas fa-times-circle text-danger fs-1" style="font-size: 60px !important;"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-800 text-dark mb-3" style="font-weight: 800; letter-spacing: -1px;">{{ __('common.payment_error') }}</h2>
                    <p class="text-muted mb-5 px-md-5">{{ __('common.payment_failure_message') }}</p>
                    
                    <div class="text-start bg-light p-4 rounded-4 mb-5 border border-white shadow-sm">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-lightbulb text-warning me-2"></i> {{ __('common.what_you_can_do') }}</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 small d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('common.check_payment_details') }}</li>
                            <li class="mb-2 small d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('common.contact_bank') }}</li>
                            <li class="small d-flex gap-2"><i class="fas fa-check text-success mt-1"></i> {{ __('common.try_different_payment') }}</li>
                        </ul>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mb-5">
                        <a href="{{ route('checkout') }}" class="modern-btn modern-btn-solid px-5 py-3 shadow-lg">
                            Try Again <i class="fas fa-redo ms-2"></i>
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-light rounded-4 px-5 py-3 fw-bold">
                            {{ __('common.home') }}
                        </a>
                    </div>

                    <div class="pt-4 border-top">
                        <h6 class="fw-bold text-dark mb-2">{{ __('common.need_assistance') }}</h6>
                        <p class="small text-muted mb-0">
                            {{ __('common.reach_out') }} 
                            <a href="mailto:{{ __('common.company_email') }}" class="fw-bold text-primary">{{ __('common.company_email') }}</a>. 
                            {{ __('common.we_are_here') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection