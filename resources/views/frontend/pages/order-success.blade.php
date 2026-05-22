@extends('frontend.layouts.main')
@section('title','Order Success')
@php
use App\Models\Order;
$order = Order::where('trans_id', $transaction_id)->first();
@endphp
@section('main-content')
<div class="tl-breadcrumb about-banner pt-120 pb-120">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('assets/images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.order_success') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.order_success') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="success-section pt-120 pb-120 bg-light">  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center">
                <div class="modern-card p-5 border-0 shadow-lg bg-white" style="border-radius: 40px;">
                    <div class="success-icon-container mb-5">
                        <div class="rounded-circle bg-soft-success d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px; background: rgba(34, 197, 94, 0.1);">
                            <i class="fas fa-check-circle text-success fs-1" style="font-size: 60px !important;"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-800 text-dark mb-3" style="font-weight: 800; letter-spacing: -1px;">{{ __('common.order_successful') }}</h2>
                    <p class="text-muted mb-5 px-md-5">{{ __('common.thank_you_order') }} Your enrollment has been confirmed and is now active in your dashboard.</p>
                    
                    <div class="bg-light p-4 rounded-4 mb-5 border border-white shadow-sm">
                        <div class="small fw-bold text-uppercase opacity-50 mb-1">{{ __('common.invoice_number') }}</div>
                        <div class="fw-bold text-dark fs-5">{{ $transaction_id }}</div>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{route('user.order.show',$order->id)}}" class="modern-btn modern-btn-solid px-5 py-3 shadow-lg">
                            {{ __('common.view_details') }} <i class="fas fa-eye ms-2"></i>
                        </a>
                        <a href="{{route('home')}}" class="btn btn-light rounded-4 px-5 py-3 fw-bold">
                            {{ __('common.home') }}
                        </a>
                    </div>

                    @if($email_status=='inactive')
                        <div class="mt-5 pt-4 border-top">
                            <div class="alert bg-soft-warning border-0 rounded-4 text-start d-flex gap-3 align-items-center">
                                <i class="fas fa-info-circle text-warning fs-4"></i>
                                <span class="small text-dark">{{ __('common.high_traffic') }} <a href="{{route('order.pdf',$order->id)}}" class="fw-bold text-primary">Download PDF Invoice</a></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
