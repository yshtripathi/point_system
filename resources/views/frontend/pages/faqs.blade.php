@extends('frontend.layouts.main')
@section('main-content')
<div class="nk-gap-1"></div>
<div class="breadcr-info">
   <div class="container">
                <ul class="nk-breadcrumbs">
                    <li><a href="{{ route('home') }}">{{ __('common.home') }}</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="">{{ __('common.faqs') }}</a></li>                  
                </ul>
            </div>
 </div>

<!-- end breadcrumb section -->


          <section class="faq-cntnt" data-aos="fade-up" style="background-image: none;">
  
      <div class="container">
         <h2>{{ __('common.faqs_heading') }}</h2>
         <div id="accordion">
            <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4">
                     <a class="card-link accordion-title" data-toggle="collapse" href="#collapseOne">
                     1. {{ __('common.faq_q1') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseOne" class="collapse show" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a1') }}</p>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseTwo">
                    2. {{ __('common.faq_q2') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseTwo" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a2') }}</p>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseThree">
                  3. {{ __('common.faq_q3') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseThree" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a3') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseFour">
                  4. {{ __('common.faq_q4') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseFour" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a4') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseFive">
                 5. {{ __('common.faq_q5') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseFive" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a5') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseSix">
                  6. {{ __('common.faq_q6') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseSix" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a6') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseSeven">
                  7. {{ __('common.faq_q7') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseSeven" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a7') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseEight">
                  8. {{ __('common.faq_q8') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseEight" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a8') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseNine">
                  9. {{ __('common.faq_q9') }}
                  </a>
                  </h2>
               </div>
               <div id="collapseNine" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a9') }}</p>
                  </div>
               </div>
            </div>
             <div class="card">
               <div class="card-header">
                  <h2 class="nk-post-title h4"> 
                     <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseTen">
                  10. {{ __('common.faq_q10') }}
                     </a>
                  </h2>
               </div>
               <div id="collapseTen" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                     <p>{{ __('common.faq_a10') }}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
  
</section>

 
<div class="nk-gap-3"></div>

@endsection