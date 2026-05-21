@extends('frontend.layouts.main')
@section('title','Login | '.env('APP_NAME'))
@section('main-content')

<div class="tl-breadcrumb about-banner pt-120 pb-120">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ __('common.login') }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ __('common.login') }}</span>
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
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="modern-card p-5 border-0 shadow-lg" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(20px); border-radius: 40px;">
                    <div class="text-center mb-5">
                        <span class="modern-badge mb-3">Welcome Back</span>
                        <h2 class="modern-h2" style="font-size: 32px;">{{ __('common.login') }}</h2>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('loginerror'))
                        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                            {{ session('loginerror') }}
                        </div>
                    @endif

                    <form name="frmLogin" id="frmLogin" action="{{route('login.submit')}}" method="post">
                        @csrf
                        <div class="mb-4">
                            <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.email') }}</label>
                            <input type="email" name="email" id="email" placeholder="{{ __('common.email') }}" value="{{old('email')}}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger small mt-2 d-block">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="small fw-bold text-uppercase opacity-50 mb-2">{{ __('common.password') }}</label>
                                <a href="{{route('forgetpwd.form')}}" class="small text-primary fw-bold mb-2">{{ __('common.lost_password_text') }}</a>
                            </div>
                            <input type="password" name="password" id="password" placeholder="{{ __('common.password') }}" class="form-control bg-light border-0 py-3 px-4 rounded-4 @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="text-danger small mt-2 d-block">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="mt-5">
                            <button class="modern-btn modern-btn-solid w-100 py-3 shadow-lg" type="submit" name="submit-form">
                                {{ __('common.login') }} <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">
                            {{ __('common.dont_have_account') }} 
                            <a href="{{route('register.form')}}" class="text-primary fw-bold">{{ __('common.sign_up') }}</a>
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#frmLogin").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                password: {
                    required: "{{ __('common.password_required') }}",
                    minlength: "{{ __('common.password_confirmation_min') }}"
                },
                email: "{{ __('common.email_required') }}"
            }
        });
    });
</script>
@endpush
