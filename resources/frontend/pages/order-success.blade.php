@extends('frontend.layouts.main')
@section('main-content')

<section class="cls-order section-space ">  
    <div class="container py-8 py-lg-9 position-relative">
        <div class="row">
         <div class="col-md-12" style="padding:0px 250px;">
             <h2 class="text-success">{{ __('common.order_successful') }}</h2>
                    <h4 class="order-invoice-number">{{ __('common.invoice_number') }}<span>{{ $transaction_id }}</span></h4>
                    <h3>{{ __('common.thank_you_order') }}</h3>
                    <h5>{{ __('common.order_confirmation') }} {{ $transaction_id }}</h5>
                    <p>{{ __('common.team_contact') }}</p>
                    <h5>{{ __('common.need_assistance') }}</h5>
                    <p>{{ __('common.reach_out_for_help') }} <a href="mailto:">{{ __('common.company_email') }}</a>.</p>
          </div>   
        </div>
     

    </div>
  </section>

@endsection