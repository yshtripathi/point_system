@extends('frontend.layouts.main')
@section('main-content')

<div class="tl-breadcrumb cart-banner pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.cart') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.cart') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="cart-section pt-120 pb-120 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Cart Items -->
            <div class="col-xl-8">
                <div class="modern-card p-4 p-md-5 border-0 shadow-sm bg-white" style="border-radius: 30px;">
                    <h5 class="fw-bold text-dark mb-5 d-flex align-items-center gap-3">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        {{ __('common.item') }} Summary
                    </h5>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-uppercase small fw-bold opacity-50">
                                    <th class="border-0 pb-4">Product</th>
                                    <th class="border-0 pb-4 text-center">{{ __('common.price') }}</th>
                                    <th class="border-0 pb-4 text-end">{{ __('common.remove') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(Helper::cartCount())
                                    @foreach(Helper::getAllProductFromCart() as $key=>$cart)
                                        @php
                                            $item_photo = asset('assets/images/placeholder.jpg');
                                            $item_title = "Points Top Up";
                                            $item_link = "#";
                                            if($cart->product) {
                                                $photo_arr = explode(',', $cart->product->photo);
                                                $item_photo = $photo_arr[0];
                                                $item_title = $cart->product->title;
                                                $item_link = route('product-detail', $cart->product->slug);
                                            }
                                        @endphp
                                        <tr class="border-bottom border-light">
                                            <td class="py-4">
                                                <div class="d-flex align-items-center gap-4">
                                                    <div class="rounded-4 overflow-hidden shadow-sm" style="width: 80px; height: 80px; flex-shrink: 0;">
                                                        <img src="{{ $item_photo }}" class="w-100 h-100 object-fit-cover" alt="{{ $item_title }}">
                                                    </div>
                                                    <div>
                                                        <a href="{{ $item_link }}" class="fw-bold text-dark text-decoration-none hover-primary d-block mb-1">{{ $item_title }}</a>
                                                        <span class="badge bg-soft-primary small" style="background: rgba(21, 145, 220, 0.1); color: #1591DC;">Learning Path</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-center">
                                                <span class="fw-800 text-dark" style="font-weight: 800;">
                                                    @if($cart->product_id < 1000 && $cart->points > 0)
                                                        <i class="fas fa-coins me-1 text-primary"></i> {{ number_format($cart->points) }} PTS
                                                    @elseif($cart->product_id >= 1000)
                                                        {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['price'], session('currency')=='JPY' ? 0 : 2) }}
                                                        <div class="text-primary tiny fw-bold mt-1">({{ number_format($cart->points) }} PTS)</div>
                                                    @else
                                                        {{ Helper::getCurrencySymbol(session('currency')) }} 
                                                        {{ number_format($cart['price'], session('currency')=='JPY' ? 0 : 2) }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="py-4 text-end">
                                                <a href="{{ route('cart-delete',$cart->id) }}" class="btn btn-light rounded-circle border-0 shadow-sm" style="width: 45px; height: 45px; line-height: 33px;">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="py-5">
                                                <i class="fas fa-shopping-basket fa-4x text-light mb-4"></i>
                                                <h4 class="text-dark fw-bold mb-3">{{ __('common.no_cart_available') }}</h4>
                                                <a href="{{route('product-lists')}}" class="modern-btn modern-btn-solid">{{ __('common.continue_shopping') }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-xl-4">
                <div class="modern-card p-5 border-0 shadow-lg bg-white sticky-top" style="border-radius: 40px; top: 120px; z-index: 10;">
                    <h5 class="fw-bold text-dark mb-5">Order Summary</h5>

                    @if(Helper::cartCount())
                        @php
                            $total_amount = Helper::totalCartPrice();
                            if(session()->has('coupon')) {
                                $total_amount -= Session::get('coupon')['value'];
                            }
                        @endphp
                        
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold text-dark">
                                @if(Helper::totalCartPoints() > 0)
                                    <i class="fas fa-coins me-1 text-primary"></i> {{ number_format(Helper::totalCartPoints()) }} PTS
                                @else
                                    {{ Helper::getCurrencySymbol(session('currency')) }} {{ number_format(Helper::totalCartPrice(), session('currency')=='JPY' ? 0 : 2) }}
                                @endif
                            </span>
                        </div>

                        <div class="mb-5 d-flex justify-content-between align-items-center pt-4 border-top">
                            <h5 class="fw-bold text-dark mb-0">Total</h5>
                            <h4 class="fw-800 text-primary mb-0" style="font-weight: 800;">
                                @if(Helper::totalCartPoints() > 0)
                                    <i class="fas fa-coins me-1"></i> {{ number_format(Helper::totalCartPoints()) }} PTS
                                @else
                                    {{ Helper::getCurrencySymbol(session('currency')) }} 
                                    {{ number_format($total_amount, session('currency')=='JPY' ? 0 : 2) }}
                                @endif
                            </h4>
                        </div>

                        <a href="{{ route('checkout') }}" class="modern-btn modern-btn-solid w-100 py-3 shadow-lg text-center mb-4">
                            {{ __('common.checkout') }} <i class="fas fa-arrow-right ms-2"></i>
                        </a>

                        <div class="text-center">
                            <img src="{{ asset('assets/images/pay.png') }}" alt="Payments" class="img-fluid opacity-50" style="max-height: 30px;">
                        </div>
                    @else
                        <div class="alert alert-light border-0 rounded-4 p-4 text-center mb-0">
                            <p class="text-muted mb-0">Your summary will appear once you add items to the cart.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .hover-primary:hover { color: var(--modern-primary) !important; }
    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
</style>
@endpush