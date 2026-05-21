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
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">
                    @if(isset($category->title) && $category->title)
                        {{$category->title}}
                    @else
                        {{ __('common.products') }}
                    @endif
                </h1></div>
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
                    <div class="modern-card h-100 border-0 bg-white overflow-hidden catalog-card" style="border-radius: 20px; box-shadow: 0 4px 20px rgba(21, 145, 220, 0.08); border: 1px solid rgba(21, 145, 220, 0.1); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <!-- Image Container -->
                        <div class="position-relative overflow-hidden" style="height: 280px; background: linear-gradient(135deg, #f0f4ff 0%, #e8f1f9 100%);">
                            <a href="{{route('product-detail',$course->slug)}}" class="d-block h-100">
                                <img src="{{url($course->photo)}}" class="w-100 h-100 object-fit-cover catalog-card-img" style="transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                            </a>
                            <!-- Category Badge -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge px-3 py-2 text-white fw-bold" style="backdrop-filter: blur(10px); background: rgba(0,0,0,0.4); border-radius: 8px; font-size: 11px; letter-spacing: 0.5px;">
                                    {{$course->condition ?? 'SELF-PACED'}}
                                </span>
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="p-5 d-flex flex-column h-100">
                            <!-- Level Badge -->
                            <div class="d-inline-flex align-items-center gap-2 mb-3" style="width: fit-content;">
                                <div style="width: 24px; height: 24px; background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-layer-group text-white" style="font-size: 12px;"></i>
                                </div>
                                <span class="text-uppercase fw-bold" style="font-size: 11px; color: #1591DC; letter-spacing: 0.5px;">Professional</span>
                            </div>

                            <!-- Title -->
                            <h5 class="fw-bold text-dark mb-auto line-clamp-2" style="font-size: 18px; line-height: 1.4; color: #0a0e27; margin-bottom: 1.5rem;">
                                <a href="{{route('product-detail',$course->slug)}}" class="text-dark text-decoration-none hover-primary" style="transition: color 0.3s ease;">
                                    {{$course->title}}
                                </a>
                            </h5>

                            <!-- Footer with Arrow -->
                            <div class="pt-4 border-top d-flex align-items-center justify-content-end" style="border-color: rgba(21, 145, 220, 0.12);">
                                <a href="{{route('product-detail',$course->slug)}}" class="btn rounded-circle border-0 d-flex align-items-center justify-content-center catalog-card-btn" style="width: 48px; height: 48px; background: linear-gradient(135deg, rgba(21, 145, 220, 0.1) 0%, rgba(21, 145, 220, 0.05) 100%); transition: all 0.3s ease;">
                                    <i class="fas fa-arrow-right" style="color: #1591DC; font-size: 18px;"></i>
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
    .catalog-card {
        position: relative;
    }

    .catalog-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 24px 48px rgba(21, 145, 220, 0.15) !important;
        border-color: rgba(21, 145, 220, 0.3) !important;
    }

    .catalog-card-img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .catalog-card:hover .catalog-card-img {
        transform: scale(1.08);
    }

    .catalog-card-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .catalog-card:hover .catalog-card-btn {
        background: linear-gradient(135deg, #1591DC 0%, #2C5EAD 100%) !important;
        transform: translateX(4px);
    }

    .catalog-card:hover .catalog-card-btn i {
        color: white !important;
    }

    .hover-primary:hover {
        color: #1591DC !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush