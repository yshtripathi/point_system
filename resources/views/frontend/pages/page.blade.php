@extends('frontend.layouts.main')
@section('title', $page_data->page_title)
@section('main-content')

<div class="tl-breadcrumb policy-banner pt-120 pb-120">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">{{ $page_data->page_title }}</h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex justify-content-md-end">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="fas fa-chevron-right mx-2"></i></span>
                        <span>{{ $page_data->page_title }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="policy-content-section pt-120 pb-120 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="modern-card p-5 p-md-5 border-0 shadow-sm bg-white" style="border-radius: 30px;">
                    <div class="policy-rich-text">
                        {!! $page_data->page_desc !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .policy-rich-text {
        font-size: 16px;
        line-height: 1.8;
        color: #4a5568;
    }
    .policy-rich-text h1, .policy-rich-text h2, .policy-rich-text h3 {
        color: #1a202c;
        font-weight: 800;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        letter-spacing: -0.5px;
    }
    .policy-rich-text p {
        margin-bottom: 1.5rem;
    }
    .policy-rich-text ul, .policy-rich-text ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .policy-rich-text li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush
