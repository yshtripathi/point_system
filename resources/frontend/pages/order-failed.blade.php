@extends('frontend.layouts.main')
@section('main-content')
<div class="tl-breadcrumb pt-120 pb-120">
    <!-- Animated bubble elements -->
    <div class="breadcrumb-float-element float-element-1"></div>
    <div class="breadcrumb-float-element float-element-2"></div>
    <div class="breadcrumb-float-element float-element-3"></div>

    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="banner-txt"><h1 class="tl-breadcrumb-title">   {{ __('common.payment_unsuccessful') }} </h1></div>
            </div>
            <div class="col-md-6">
                <ul class="tl-breadcrumb-nav d-flex">
                    <li><a href="/">{{ __('common.home') }}</a></li>
                    <li class="current-page">
                        <span class="dvdr"><i class="lnr lnr-icon-chevron-right"></i>

</span
                        ><span><a href="#">  {{ __('common.payment_unsuccessful') }} </a></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section class="cls-order section-space ">  
    <div class="container position-relative">
        <div class="row">
          <div class="col-xl-7 col-lg-7 col-12 offset-lg-2 text-center" >
           <div class="order-winfo">    
              <h2 class="order-failed text-danger">{{ __('common.payment_unsuccessful') }}</h2>
                                <h3>{{ __('common.payment_error') }}</h3>
                                <p>{{ __('common.payment_failure_message') }}</p>
                                <h5>{{ __('common.what_you_can_do') }}</h5>
                                <ul>
                                <li>{{ __('common.check_payment_details') }}</li>
                                <li>{{ __('common.contact_bank') }}</li>
                                <li>{{ __('common.try_different_payment') }}</li>
                                </ul>
                                <h5>{{ __('common.need_assistance') }}</h5>
                                <p>{{ __('common.reach_out') }} <a href="mailto:">{{ __('common.company_email') }}</a>. {{ __('common.we_are_here') }}</p>
          </div> 
        </div>
      </div>
    </div>
  </section>

@endsection