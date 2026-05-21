@extends('frontend.layouts.main')
@section('main-content')
<style>
    #delivery-error::before, #privacy-error::before, #terms-error::before, #refund-error::before { display:none; }
    .checkout-page__payment__button label { font-size: 14px; padding-left: 10px; cursor: pointer; color: var(--text-light); }
</style>

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
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.checkout') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.checkout') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


@php
                            $is_points_bundle = false;
                            if(Helper::getAllProductFromCart()) {
                                foreach(Helper::getAllProductFromCart() as $cart) {
                                    if($cart->product_id >= 1000) { $is_points_bundle = true; break; }
                                }
                            }
                            $total_amount = Helper::totalCartPrice();
                            if(session()->has('coupon')) { $total_amount -= Session::get('coupon')['value']; }
                        @endphp

<form name="frmCheckout" id="frmCheckout" method="POST" action="{{route('cart.order')}}">
    @csrf
    <section class="checkout-section pt-60 pb-60 bg-light">
        <div class="container">
            <div class="row g-5">
                <!-- Left: Billing Details -->
                <div class="col-xl-8">
                    <div class="modern-card p-5 border-0 shadow-sm bg-white mb-5" style="border-radius: 24px; border: 1px solid rgba(21, 145, 220, 0.1);">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <h3 class="fw-bold mb-0" style="color: #0a0e27;">{{ __('common.billing_details')}}</h3>
                            <i class="fas fa-id-card" style="color: #1591DC; font-size: 28px;"></i>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-user" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.first_name') }}
                                </label>
                                <input type="text" name="first_name" value="" placeholder="e.g. John" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('first_name') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-user" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.last_name') }}
                                </label>
                                <input type="text" name="last_name" value="" placeholder="e.g. Doe" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('last_name') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-envelope" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.email') }}
                                </label>
                                <input name="email" type="email" value="{{ auth()->user() ? auth()->user()->email : '' }}" placeholder="email@example.com" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('email') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-phone" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.phone') }}
                                </label>
                                <input type="tel" name="phone" placeholder="Phone Number" value="{{ auth()->user() ? auth()->user()->phone : '' }}" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('phone') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.address') }}
                                </label>
                                <input type="text" name="address1" value="{{ auth()->user() ? auth()->user()->address : '' }}" placeholder="Street Address" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('address') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-city" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.town_city') }}
                                </label>
                                <input type="text" name="city" value="{{ auth()->user() ? auth()->user()->city : '' }}" placeholder="City" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('city') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-map" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.state') }}
                                </label>
                                <input type="text" name="state" value="{{ auth()->user() ? auth()->user()->state : '' }}" placeholder="State" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('state') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-mailbox" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.zip_code') }}
                                </label>
                                <input type="text" name="post_code" placeholder="Zip Code" value="{{ auth()->user() ? auth()->user()->zip : '' }}" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                @error('post_code') <span class='text-danger small mt-2 d-block'><i class="fas fa-info-circle me-1"></i>{{$message}}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                    <i class="fas fa-globe" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                    {{ __('common.country') }}
                                </label>
                                <select name="country" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                    <option value="">{{ __('common.select_country') }}</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="JP">Japan</option>
                                    <option value="HK">Hong Kong</option>
                                    <!-- Simplified for brevity, usually you'd iterate a list -->
                                    <option value="IN">India</option>
                                </select>
                                @error('country') <span class="text-danger small mt-2 d-block"><i class="fas fa-info-circle me-1"></i>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if(!$is_points_bundle)
                            <!-- Pay with Points -->
                            <div class="points-payment-section mt-5">
                                <div class="p-4 rounded-3 mb-4" style="background: rgba(21, 145, 220, 0.08); border: 1px solid rgba(21, 145, 220, 0.1);">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="small fw-bold" style="color: #666;">Balance</span>
                                        <span class="small fw-800" style="color: #0a0e27;">{{ number_format(auth()->user() ? auth()->user()->points_balance : 0) }} <i class="fas fa-coins" style="color: #1591DC; margin-left: 4px;"></i> PTS</span>
                                    </div>
                                    @php
                                        $total_points_needed = Helper::totalCartPoints();
                                    @endphp
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold" style="color: #666;">Required</span>
                                        <span class="small fw-800" style="color: #1591DC;">{{ number_format($total_points_needed) }} PTS</span>
                                    </div>
                                </div>

                                @if(auth()->user() && auth()->user()->points_balance < $total_points_needed)
                                    <div class="alert border-0 small rounded-3 mb-4" style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107;">
                                        <i class="fas fa-exclamation-circle me-2" style="color: #ff9800;"></i> <span style="color: #333;">Insufficient points. <a href="{{ route('points.topup') }}" class="fw-bold" style="color: #1591DC; text-decoration: none;">Top Up</a></span>
                                    </div>
                                @endif

                                <button type="button" onclick="document.getElementById('frmRedeemPoints').submit();"
                                        class="w-100 py-3 rounded-3 fw-bold border-0 text-white"
                                        style="background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%); box-shadow: 0 4px 12px rgba(21, 145, 220, 0.3); transition: all 0.3s ease;"
                                        @if(auth()->user() && auth()->user()->points_balance < $total_points_needed) disabled @endif>
                                    {{ __('common.confirm_and_enroll') }}
                                </button>
                            </div>
                        @else
                            <!-- Card Payment (simplified) -->
                            <div class="card-payment-section mt-5">
                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                            <i class="fas fa-credit-card" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                            Card Holder
                                        </label>
                                        <input type="text" id="name_on_card" name="name_on_card" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);" placeholder="Name on card">
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                            <i class="fas fa-credit-card" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                            Card Number
                                        </label>
                                        <input type="text" id="card_number" name="card_number" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);" placeholder="•••• •••• •••• ••••">
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                            <i class="fas fa-calendar" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                            Expiry
                                        </label>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="number" id="expiry_month" name="expiry_month" placeholder="MM" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                            <span style="color: #0a0e27; font-weight: 600;">/</span>
                                            <input type="number" id="expiry_year" name="expiry_year" placeholder="YYYY" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-uppercase opacity-75 mb-2 d-flex align-items-center">
                                            <i class="fas fa-lock" style="color: #1591DC; font-size: 12px; margin-right: 8px;"></i>
                                            CVC
                                        </label>
                                        <input type="tel" id="cvv" name="cvv" placeholder="•••" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);">
                                    </div>
                                </div>
                                <button type="button" class="w-100 py-3 rounded-3 fw-bold border-0 text-white" style="background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%); box-shadow: 0 4px 12px rgba(21, 145, 220, 0.3); transition: all 0.3s ease;" id="button-confirm">
                                    {{ __('common.place_order') }}
                                </button>
                            </div>
                        @endif

                        <div class="mt-5">
                            <h5 class="fw-bold mb-3" style="color: #0a0e27;">{{ __('common.additional_information') }}</h5>
                            <textarea name="notes" placeholder="{{ __('common.notes_about_order') }}" class="form-control form-control-lg bg-light border-1 py-3 px-4 rounded-3" style="border-color: rgba(21, 145, 220, 0.15);" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right: Order & Payment -->
                <div class="col-xl-4">
                    <div class="modern-card p-5 border-0 shadow-sm bg-white mb-5 sticky-top" style="border-radius: 24px; border: 1px solid rgba(21, 145, 220, 0.1); top: 120px; z-index: 10;">
                        <h5 class="fw-bold mb-4" style="color: #0a0e27; font-size: 18px;">{{ __('common.your_order') }}</h5>

                        <div class="order-items-mini mb-4">
                            @if(Helper::getAllProductFromCart())
                                @foreach(Helper::getAllProductFromCart() as $key => $cart)
                                    <div class="d-flex justify-content-between mb-3 pb-3 align-items-center" style="border-bottom: 1px solid rgba(21, 145, 220, 0.1);">
                                        <div class="small">
                                            <div class="fw-bold" style="color: #0a0e27;">{{ ($cart->product) ? $cart->product->title : "Points Top Up" }}</div>
                                            <div style="color: #999; font-size: 13px;">
                                                @if($cart->points > 0)
                                                    {{ $cart->quantity }} x {{ number_format($cart->points) }} PTS
                                                @else
                                                    {{ $cart->quantity }} x {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['price'], session('currency')=='JPY' ? 0 : 2) }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fw-bold" style="color: #0a0e27;">
                                            @if($cart->points > 0)
                                                <i class="fas fa-coins me-1" style="color: #1591DC;"></i> {{ number_format($cart->points * $cart->quantity) }} PTS
                                            @else
                                                {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['amount'], session('currency')=='JPY' ? 0 : 2) }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5 pt-4" style="border-top: 2px solid rgba(21, 145, 220, 0.15);">
                            <h5 class="fw-bold mb-0" style="color: #0a0e27;">Total</h5>
                            <h4 class="fw-800 mb-0" style="font-weight: 800; color: #1591DC;">
                                @if(Helper::totalCartPoints() > 0)
                                    <i class="fas fa-coins me-1"></i> {{ number_format(Helper::totalCartPoints()) }} PTS
                                @else
                                    {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($total_amount, session('currency')=='JPY' ? 0 : 2) }}
                                @endif
                            </h4>
                        </div>

                        <!-- Policy Checks -->
                        <div class="policy-checks mb-0 p-4 rounded-3" style="background: rgba(21, 145, 220, 0.05); border: 1px solid rgba(21, 145, 220, 0.1);">
                            @php $policies = ['terms' => 'terms_policy', 'privacy' => 'privacy_policy', 'delivery' => 'delivery_policy', 'refund' => 'refund_policy']; @endphp
                            @foreach($policies as $id => $lang_key)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="{{$id}}" name="{{$id}}" style="border-color: rgba(21, 145, 220, 0.3); width: 18px; height: 18px;">
                                    <label class="form-check-label small" for="{{$id}}" style="color: #666; margin-left: 8px;">
                                        {{ __('common.agree_terms_text') }} <a href="{{ route('pages', str_replace('_', '-', $id)) }}" target='_blank' style="color: #1591DC; text-decoration: none; font-weight: 600;">{{ __('common.' . $lang_key) }}</a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

@if(!$is_points_bundle)
<form id="frmRedeemPoints" action="{{ route('points.redeem') }}" method="POST" style="display:none;">
    @csrf
</form>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#frmCheckout").validate({
            rules: { first_name: "required", last_name: "required", email: { required: true, email: true }, phone: { required: true, minlength: 10 }, address1: "required", post_code:"required", city: "required", state:"required", country: "required", terms:"required", privacy:"required", delivery:"required", refund:"required" },
            messages: { first_name: "{{ __('common.name_required1') }}", last_name: "{{ __('common.name_required2') }}", phone: { required: "{{ __('common.phone_required') }}", minlength: "{{ __('common.phone_min') }}" }, address1: "{{ __('common.address_required') }}", email: "{{ __('common.email_required') }}", post_code:"{{ __('common.post_code_required') }}", city:"{{ __('common.city_required') }} ", state:"{{ __('common.state_required') }}", country: "{{ __('common.country_required') }}", terms:"{{ __('common.accept_terms_conditions') }}", privacy:"{{ __('common.accept_privacy_policy') }}", delivery:"{{ __('common.accept_delivery_policy') }}", refund:"{{ __('common.accept_refund_policy') }}" }
        });
        
        $('#button-confirm').click(function(){
            if($("#frmCheckout").valid()){
                $('#frmCheckout').submit();
            }
        });
    });
</script>
@endpush