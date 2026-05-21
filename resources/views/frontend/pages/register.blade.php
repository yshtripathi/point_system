@extends('frontend.layouts.main')
@section('title','Register | '.env('APP_NAME'))
@section('main-content')

<div class="tl-breadcrumb about-banner pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.register') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.register') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="auth-section pt-120 pb-120 bg-light" style="position: relative; overflow: hidden;">
    <!-- Decorative Blobs -->
    <div class="modern-blob modern-blob-1" style="top: -100px; left: -100px; width: 400px; height: 400px; background: var(--primary-10);"></div>
    <div class="modern-blob modern-blob-2" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: var(--primary-10);"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="modern-card p-5 border-0 shadow-lg" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(20px); border-radius: 40px;">
                    <div class="text-center mb-5">
                        <span class="modern-badge mb-3">Join Our Community</span>
                        <h2 class="modern-h2" style="font-size: 32px;">{{ __('common.register') }}</h2>
                    </div>

                    <form name="frmRegister" id="frmRegister" action="{{route('register.submit')}}" method="post">  
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.name') }}</label>
                                <input type="text" name="name" id="name" placeholder="{{ __('common.name') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('name') is-invalid @enderror" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger small mt-2 d-block">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.email') }}</label>
                                <input type="email" name="email" id="email" placeholder="{{ __('common.email') }}" value="{{old('email')}}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <span class="text-danger small mt-2 d-block">{{$message}}</span>
                                @enderror  
                            </div>

                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.password') }}</label>
                                <input type="password" name="password" id="password" placeholder="{{ __('common.password') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <span class="text-danger small mt-2 d-block">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('common.confirm_password') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4">
                                @error('password_confirmation')
                                    <span class="text-danger small mt-2 d-block">{{$message}}</span>
                                @enderror
                            </div>

                            @if(env('CAPTCHA_ENABLED', true))
                                <div class="col-12">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-8">
                                            <input type="text" id="captcha" name="captcha" autocomplete="off" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="{{ __('common.fill_captcha') }}" required>
                                        </div>
                                        <div class="col-md-4 cpatcha-imgs text-center">
                                            @captcha
                                        </div>
                                    </div>
                                    @error('captcha')
                                        <span class="text-danger small mt-2 d-block">{{ __('common.captcha_error') }}</span>
                                    @enderror 
                                </div>
                            @endif

                            <div class="col-12 mt-5">
                                <button class="modern-btn modern-btn-solid w-100 py-3 shadow-lg" type="submit" name="submit-form">
                                    {{ __('common.register') }} <i class="fas fa-user-plus ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form> 

                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">
                            {{ __('common.already_account') }} 
                            <a href="{{route('login.form')}}" class="text-primary fw-bold">{{ __('common.login') }}</a>
                        </p>
                    </div>
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
    .cpatcha-imgs img { border-radius: var(--radius-lg); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#frmRegister").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirmation: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                @if(env('CAPTCHA_ENABLED', true))
                captcha: "required"
                @endif
            },
            messages: {
                name: "{{ __('common.name_required') }}",
                password: {
                    required: "{{ __('common.password_required') }}",
                    minlength: "{{ __('common.password_min') }}"
                },
                password_confirmation: {
                    required: "{{ __('common.password_confirmation_required') }}",
                    minlength: "{{ __('common.password_confirmation_min') }}",
                    equalTo: "Passwords do not match."
                },
                email: "{{ __('common.email_required') }}",
                @if(env('CAPTCHA_ENABLED', true))
                captcha: "{{ __('common.fill_it') }}" 
                @endif
            }
        });
    });
</script>
@endpush
