@extends('frontend.layouts.main')

@section('title', $product_detail->title)
@section('description', $product_detail->summary)

@section('main-content')
<div class="tl-breadcrumb catalog-banner pt-60 pb-60">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ $product_detail->title }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="{{route('home')}}">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ $product_detail->title }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="product-details-section pt-120 pb-120 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Course Levels & Enrollment -->
            <div class="col-xl-7">
                <div class="modern-card p-5 border-0 shadow-lg bg-white h-100" style="border-radius: 40px;">
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <h3 class="fw-800 text-dark mb-0" style="font-weight: 800; letter-spacing: -1px;">Select Your Level</h3>
                        <div class="badge bg-soft-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-signal me-2"></i> Professional Tiers
                        </div>
                    </div>

                    <div class="level-tabs-container">
                        <!-- Navigation Pills for Levels -->
                        <ul class="nav nav-pills modern-pills mb-5 p-2 bg-light rounded-pill d-inline-flex" id="levelTabs" role="tablist">
                            @foreach($product_detail->levels as $key => $level)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4 py-2 fw-bold @if($loop->first) active @endif" 
                                            id="level-tab-{{ $level->id }}" 
                                            data-bs-toggle="pill" 
                                            data-bs-target="#level-content-{{ $level->id }}" 
                                            type="button" role="tab">
                                        {{ $level->skill_level }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Tab Contents -->
                        <div class="tab-content" id="levelTabsContent">
                            @foreach($product_detail->levels as $key => $level)
                                <div class="tab-pane fade @if($loop->first) show active @endif" 
                                     id="level-content-{{ $level->id }}" 
                                     role="tabpanel">
                                    
                                    <div class="level-info-grid mb-5">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="p-4 rounded-4 bg-light h-100 border border-white shadow-sm">
                                                    <h6 class="text-uppercase small fw-bold opacity-50 mb-3">{{__('common.purpose')}}</h6>
                                                    <p class="text-dark fw-bold mb-0">{{ $level->purpose }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-4 rounded-4 bg-soft-primary h-100 border border-white shadow-sm" style="background: var(--secondary-20);">
                                                    <h6 class="text-uppercase small fw-bold opacity-50 mb-3">{{__('common.outcome')}}</h6>
                                                    <p class="text-dark fw-bold mb-0">{{ $level->outcome }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="learn-list mb-5">
                                        <h6 class="fw-bold text-dark mb-4"><i class="fas fa-check-circle text-success me-2"></i> {{__('common.what_learn')}}</h6>
                                        <div class="row g-3">
                                            @php $items = explode('.', $level->learn_info); @endphp
                                            @foreach($items as $item)
                                                @if(trim($item) != '')
                                                    <div class="col-md-6">
                                                        <div class="d-flex gap-3 align-items-center p-3 rounded-3 bg-white border border-light">
                                                            <i class="fas fa-chevron-right text-primary small"></i>
                                                            <span class="small text-muted">{{ trim($item) }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="enrollment-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 pt-5 border-top">
                                        <div class="price-display">
                                            <div class="text-muted small fw-bold text-uppercase mb-1">Required Points</div>
                                            <h2 class="fw-800 text-primary mb-0" style="font-weight: 800;">
                                                <i class="fas fa-coins me-2"></i>{{ number_format($level->price_in_points) }} <span class="fs-6 opacity-50">PTS</span>
                                            </h2>
                                        </div>
                                        
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="flex-grow-1 flex-md-grow-0">
                                            @csrf
                                            <input type="hidden" name="quant[1]" value="1">
                                            <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                            <input type="hidden" name="price" value="{{$level->price}}">
                                            <input type="hidden" name="price_jp" value="{{$level->price_jp}}">
                                            <input type="hidden" name="price_hk" value="{{$level->price_hk}}">
                                            <input type="hidden" name="level_id" value="{{$level->id}}">
                                            <button type="submit" class="modern-btn modern-btn-solid w-100 px-5 py-3 shadow-lg">
                                                Enroll Now <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Media & Description -->
            <div class="col-xl-5">
                <div class="sticky-top" style="top: 120px;">
                    <div class="modern-card p-4 border-0 shadow-lg bg-white mb-4 overflow-hidden" style="border-radius: 40px;">
                        @php $photo = explode(',', $product_detail->photo); @endphp
                        <div class="rounded-4 overflow-hidden shadow-sm mb-4">
                            <img src="{{ asset($photo[0]) }}" class="w-100 object-fit-cover" style="height: 300px;">
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold text-dark mb-3">Course Overview</h5>
                            <p class="text-muted mb-0 lh-lg" style="font-size: 0.95rem;">{{$product_detail->description}}</p>
                        </div>
                    </div>

                    <div class="modern-card p-4 border-0 shadow-sm bg-white" style="border-radius: 30px;">
                        <div class="d-flex align-items-center gap-3 text-primary">
                            <i class="fas fa-shield-alt fs-4"></i>
                            <div>
                                <div class="fw-bold small">Lifetime Enrollment</div>
                                <div class="text-muted tiny">Secure your future learning</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .modern-pills .nav-link {
        color: var(--text-light);
        transition: var(--transition-base);
        border: 2px solid transparent;
        background: transparent !important;
    }
    .modern-pills .nav-link.active {
        background: var(--white) !important;
        color: var(--primary) !important;
        box-shadow: var(--shadow-sm);
    }
    .tiny { font-size: 0.75rem; }
</style>
@endpush