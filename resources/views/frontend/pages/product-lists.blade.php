@extends('frontend.layouts.main')

@if(isset($category->title) && $category->title)
    @section('title', $category->title)
    @section('description', $category->summary)
@else
    @section('title', __('common.all_courses_text'))
    @section('description', __('common.all_courses_text'))
@endif

@section('main-content')
<div class="tl-breadcrumb catalog-banner pt-60 pb-60">
    <video autoplay muted loop playsinline>
        <source src="{{ asset('images/breadcrumb.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt">
                    <h1 class="tl-breadcrumb-title">
                        @if(isset($category->title) && $category->title)
                            {{$category->title}}
                        @else
                            {{ __('common.products') }}
                        @endif
                    </h1>
                </div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>
                            @if(isset($category->title) && $category->title)
                                {{$category->title}}
                            @else
                                {{ __('common.products') }}
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="catalog-section pt-60 pb-80 bg-light">   
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-0">
                    <span class="text-primary">{{$products->count()}}</span> {{ __('common.courses') }} Available
                </h4>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="catalog-filter d-inline-flex gap-3">
                    <!-- Placeholder for future filters if needed -->
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($products as $course)     
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="modern-card h-100 border-0 shadow-sm bg-white overflow-hidden" style="border-radius: 24px; transition: transform 0.3s ease;">
                        <div class="position-relative">
                            <a href="{{route('product-detail',$course->slug)}}" class="d-block overflow-hidden">
                                <img src="{{url($course->photo)}}" class="w-100 object-fit-cover catalog-card-img" style="height:280px; transition: transform 0.5s ease;">
                            </a>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-blur px-3 py-2 text-white" style="backdrop-filter: blur(10px); background: rgba(0,0,0,0.3); border-radius: 10px;">
                                    {{$course->condition ?? 'Self-Paced'}}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 p-xl-5">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-layer-group text-primary small"></i>
                                <span class="text-uppercase small fw-bold opacity-50 letter-spacing-1">Professional</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-4 line-clamp-2" style="min-height: 3rem;">
                                <a href="{{route('product-detail',$course->slug)}}" class="text-dark text-decoration-none hover-primary">
                                    {{$course->title}}
                                </a>
                            </h5>
                            
                            <div class="pt-4 border-top d-flex align-items-center justify-content-end">
                                <a href="{{route('product-detail',$course->slug)}}" class="btn btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-arrow-right text-primary"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .catalog-card-img:hover {
        transform: scale(1.05);
    }
    .modern-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
    }
    .hover-primary:hover {
        color: var(--modern-primary) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush