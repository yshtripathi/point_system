@extends('frontend.layouts.main')
@section('main-content')
<style>
    #delivery-error::before, #privacy-error::before, #terms-error::before, #refund-error::before { display:none; }
    .checkout-page__payment__button label { font-size: 14px; padding-left: 10px; cursor: pointer; color: var(--text-light); }
    .form-control { border-radius: var(--radius-md); border: 1px solid var(--border-light); padding: 12px 20px; }
    .form-control:focus { box-shadow: 0 0 0 4px var(--secondary-10); border-color: var(--secondary); }
    .checkout-page__title { font-weight: 800; letter-spacing: -0.5px; }
</style>

<div class="tl-breadcrumb cart-banner pt-120 pb-120">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
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
    <section class="checkout-section pt-120 pb-120 bg-light">
        <div class="container">
            <div class="row g-5">
                <!-- Left: Billing Details -->
                <div class="col-xl-8">
                    <div class="modern-card p-5 border-0 shadow-sm bg-white mb-5" style="border-radius: 30px;">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <h3 class="checkout-page__title text-dark mb-0">{{ __('common.billing_details')}}</h3>
                            <i class="fas fa-id-card text-primary fs-3"></i>
                        </div>

                        @if (session('success')) <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">{{ session('success') }}</div> @endif
                        @if (session('error')) <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">{{ session('error') }}</div> @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.first_name') }}*</label>
                                <input type="text" name="first_name" value="" placeholder="e.g. John" class="form-control">
                                @error('first_name') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.last_name') }}*</label>
                                <input type="text" name="last_name" value="" placeholder="e.g. Doe" class="form-control">
                                @error('last_name') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.email') }}*</label>
                                <input name="email" type="email" value="{{ auth()->user() ? auth()->user()->email : '' }}" placeholder="email@example.com" class="form-control">
                                @error('email') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.phone') }}*</label>
                                <input type="tel" name="phone" placeholder="Phone Number" value="{{ auth()->user() ? auth()->user()->phone : '' }}" class="form-control">
                                @error('phone') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.address') }}*</label>
                                <input type="text" name="address1" value="{{ auth()->user() ? auth()->user()->address : '' }}" placeholder="Street Address" class="form-control">
                                @error('address') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.town_city') }}*</label>
                                <input type="text" name="city" value="{{ auth()->user() ? auth()->user()->city : '' }}" placeholder="City" class="form-control">
                                @error('city') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.state') }}*</label>
                                <input type="text" name="state" value="{{ auth()->user() ? auth()->user()->state : '' }}" placeholder="State" class="form-control">
                                @error('state') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.zip_code') }}*</label>
                                <input type="text" name="post_code" placeholder="Zip Code" value="{{ auth()->user() ? auth()->user()->zip : '' }}" class="form-control">
                                @error('post_code') <span class='text-danger small mt-2 d-block'>{{$message}}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.country') }}*</label>
                                <select name="country" class="form-control">
                                    <option value="">{{ __('common.select_country') }}</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="JP">Japan</option>
                                    <option value="HK">Hong Kong</option>
                                    <!-- Simplified for brevity, usually you'd iterate a list -->
                                    <option value="IN">India</option>
                                </select>
                                @error('country') <span class="text-danger small mt-2 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if(!$is_points_bundle)
                            <!-- Pay with Points -->
                            <div class="points-payment-section">
                                <div class="p-3 rounded-4 bg-soft-primary mb-4" style="background: var(--primary-10);">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small fw-bold text-muted">Balance</span>
                                        <span class="small fw-800 text-dark">{{ number_format(auth()->user() ? auth()->user()->points_balance : 0) }} PTS</span>
                                    </div>
                                    @php
                                        $total_points_needed = Helper::totalCartPoints();
                                    @endphp
                                    <div class="d-flex justify-content-between">
                                        <span class="small fw-bold text-muted">Required</span>
                                        <span class="small fw-800 text-primary">{{ number_format($total_points_needed) }} PTS</span>
                                    </div>
                                </div>

                                @if(auth()->user() && auth()->user()->points_balance < $total_points_needed)
                                    <div class="alert alert-warning border-0 small rounded-4 mb-4">
                                        <i class="fas fa-exclamation-circle me-2"></i> Insufficient points. <a href="{{ route('points.topup') }}" class="fw-bold">Top Up</a>
                                    </div>
                                @endif

                                <button type="button" onclick="document.getElementById('frmRedeemPoints').submit();" 
                                        class="modern-btn modern-btn-solid w-100 py-3 shadow-lg"
                                        @if(auth()->user() && auth()->user()->points_balance < $total_points_needed) disabled @endif>
                                    {{ __('common.confirm_and_enroll') }}
                                </button>
                            </div>
                        @else
                            <!-- Card Payment (simplified) -->
                            <div class="card-payment-section">
                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted mb-1">Card Holder</label>
                                        <input type="text" id="name_on_card" name="name_on_card" class="form-control" placeholder="Name on card">
                                    </div>
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted mb-1">Card Number</label>
                                        <input type="text" id="card_number" name="card_number" class="form-control" placeholder="•••• •••• •••• ••••">
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">Expiry</label>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="number" id="expiry_month" name="expiry_month" placeholder="MM" class="form-control">
                                            <span>/</span>
                                            <input type="number" id="expiry_year" name="expiry_year" placeholder="YYYY" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">CVC</label>
                                        <input type="tel" id="cvv" name="cvv" placeholder="•••" class="form-control">
                                    </div>
                                </div>
                                <button type="button" class="modern-btn modern-btn-solid w-100 py-3 shadow-lg" id="button-confirm">
                                    {{ __('common.place_order') }}
                                </button>
                            </div>
                        @endif

                        <div class="mt-5">
                            <h5 class="fw-bold text-dark mb-3">{{ __('common.additional_information') }}</h5>
                            <textarea name="notes" placeholder="{{ __('common.notes_about_order') }}" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right: Order & Payment -->
                <div class="col-xl-4">
                    <div class="modern-card p-5 border-0 shadow-lg bg-white mb-5 sticky-top" style="border-radius: 40px; top: 120px; z-index: 10;">
                        <h5 class="fw-bold text-dark mb-4">{{ __('common.your_order') }}</h5>
                        
                        

                        <div class="order-items-mini mb-4">
                            @if(Helper::getAllProductFromCart())
                                @foreach(Helper::getAllProductFromCart() as $key => $cart)
                                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light align-items-center">
                                        <div class="small">
                                            <div class="fw-bold text-dark">{{ ($cart->product) ? $cart->product->title : "Points Top Up" }}</div>
                                            <div class="text-muted">
                                                @if($cart->points > 0)
                                                    {{ $cart->quantity }} x {{ number_format($cart->points) }} PTS
                                                @else
                                                    {{ $cart->quantity }} x {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['price'], session('currency')=='JPY' ? 0 : 2) }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fw-bold text-dark">
                                            @if($cart->points > 0)
                                                <i class="fas fa-coins me-1 text-primary"></i> {{ number_format($cart->points * $cart->quantity) }} PTS
                                            @else
                                                {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($cart['amount'], session('currency')=='JPY' ? 0 : 2) }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h5 class="fw-bold text-dark mb-0">Total</h5>
                            <h4 class="fw-800 text-primary mb-0" style="font-weight: 800;">
                                @if(Helper::totalCartPoints() > 0)
                                    <i class="fas fa-coins me-1"></i> {{ number_format(Helper::totalCartPoints()) }} PTS
                                @else
                                    {{ Helper::getCurrencySymbol(session('currency')) }}{{ number_format($total_amount, session('currency')=='JPY' ? 0 : 2) }}
                                @endif
                            </h4>
                        </div>

                        <!-- Policy Checks -->
                        <div class="policy-checks mb-5 p-4 bg-light rounded-4">
                            @php $policies = ['terms' => 'terms_policy', 'privacy' => 'privacy_policy', 'delivery' => 'delivery_policy', 'refund' => 'refund_policy']; @endphp
                            @foreach($policies as $id => $lang_key)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="{{$id}}" name="{{$id}}">
                                    <label class="form-check-label small" for="{{$id}}">
                                        {{ __('common.agree_terms_text') }} <a href="{{ route('pages', str_replace('_', '-', $id)) }}" target='_blank'>{{ __('common.' . $lang_key) }}</a>
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