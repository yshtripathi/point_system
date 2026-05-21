@extends('frontend.layouts.main')
@section('main-content')
@section('title', $page_data->page_title)
<section class="page-title" style="background-image: url(images/background/page-title.jpg);">
	<div class="auto-container">
		<div class="title-outer">
			<h1 class="title">{{ $page_data->page_title }}</h1>
			<ul class="page-breadcrumb">
				<li><a href="{{ route('home') }}">{{ __('common.home') }}</a></li>
				<li> {{ $page_data->page_title }}</li>
			</ul>
		</div>
	</div>
</section>
<!-- end main-content -->

<section class="term-cntnt">
	<div class="container">
		<div class="page-cntnt p-5 border shadow">
		 {!! $page_data->page_desc !!}   
		</div>
	</div>
</section>

@endsection
