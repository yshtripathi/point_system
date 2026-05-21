@extends('frontend.layouts.main')
@section('title','Contact Us | '.env('APP_NAME'))
@section('main-content')

<div class="tl-breadcrumb contact-banner pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.contact') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.contact') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="contact-page-section pt-120 pb-120">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Contact Details -->
            <div class="col-xl-4 col-lg-5">
                <span class="modern-badge mb-3">{{ __('common.get_in_touch') }}</span>
                <h2 class="modern-h2 mb-5">We'd love to hear from you</h2>
                
                <div class="contact-info-cards">
                    <div class="modern-card p-4 mb-4 border-0 shadow-sm d-flex align-items-start gap-3">
                        <div class="modern-cart-btn bg-primary text-white border-0 flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('common.email') }}</h6>
                            <a href="mailto:{{ $misc['Company Email'] ?? __('common.company_email') }}" class="text-muted">{{ $misc['Company Email'] ?? __('common.company_email') }}</a>
                        </div>
                    </div>

                    <div class="modern-card p-4 mb-4 border-0 shadow-sm d-flex align-items-start gap-3">
                        <div class="modern-cart-btn bg-primary text-white border-0 flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('common.our_location') }}</h6>
                            <span class="text-muted">{{ $misc['Company Address'] ?? __('common.company_Address') }}</span>
                        </div>
                    </div>

                    <div class="modern-card p-4 mb-4 border-0 shadow-sm d-flex align-items-start gap-3">
                        <div class="modern-cart-btn bg-primary text-white border-0 flex-shrink-0" style="width: 50px; height: 50px;">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('common.company') }}</h6>
                            <span class="text-muted">{{ $misc['Company Name'] ?? __('common.company_name') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="col-xl-8 col-lg-7 ps-xl-5">
                <div class="modern-card p-5 border-0 shadow-lg" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}" id="contactform">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.name') }}</label>
                                <input type="text" name="name" id="name" placeholder="{{ __('common.enter_name') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('name') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.email') }} *</label>
                                <input type="email" name="email" id="email" placeholder="{{ __('common.enter_email') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('email') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.phone') }} *</label>
                                <input type="text" name="phone" id="phone" placeholder="{{ __('common.phone') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('phone') is-invalid @enderror" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.your_subject') }} *</label>
                                <input type="text" name="subject" id="subject" placeholder="{{ __('common.enter_subject') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.your_message') }} *</label>
                                <textarea name="message" id="message" rows="5" placeholder="{{ __('common.enter_message') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4"></textarea>
                            </div>

                            @if(env('CAPTCHA_ENABLED', true))
                                <div class="col-12">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-8">
                                            <input type="text" id="captcha" name="captcha" autocomplete="off" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="{{ __('common.fill_captcha') }}" required>
                                        </div>
                                        <div class="col-md-4 cpatcha-imgs">
                                            @captcha
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12 mt-5">
                                <button type="submit" class="modern-btn modern-btn-solid w-100 py-3 shadow-lg">
                                    <span>{{ __('common.send_message') }} <i class="fas fa-paper-plane ms-2"></i></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .error { color: #dc3545 !important; font-size: 13px; margin-top: 5px; font-weight: 500; }
    .form-control:focus { background-color: var(--white) !important; box-shadow: 0 0 0 4px var(--primary-10); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#contactform").validate({
            rules: {
                name: "required",
                subject: "required",                
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                message: "required",
                @if(env('CAPTCHA_ENABLED', true))
                captcha: "required"
                @endif
            },
            messages: {
                name: "{{ __('common.name_required') }}",
                subject: " {{ __('common.subject_required') }}",
                email: "{{ __('common.email_required') }}",            
                phone: {
                    required: " {{ __('common.phone_required') }}",
                    minlength: "{{ __('common.phone_min') }}"
                },
                message: " {{ __('common.message_required') }}"
            }
        });
    });
</script>
@endpush