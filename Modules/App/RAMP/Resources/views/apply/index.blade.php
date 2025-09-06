@extends('core::layouts.app.index')

@section('main-content')

<div class="row">

	<div class="col w-full">	
		<div class="row">
			<div class="col w-6/12 content-end">
				{{ Breadcrumbs::render('app.ramp.apply')}}
			</div>
			<div class="col w-6/12 flex items-end justify-end">
				{{--  --}}
			</div>
		</div>
		<div class="col w-full border-border border-t my-6"></div>
	</div>

	<div class="col w-full">
		<div class="uk-card uk-card-body">
			<h3 class="uk-card-title">List of events open for applications</h3>
			<ul class="uk-list uk-list-hyphen mt-8">
				@foreach ($events as $event)
					<li class="mb-4">
						<a class="uk-link" href="{{route('app.ramp.apply.create', ['event' => $event['id']])}}"> 
							<span class="mr-2">{{$event['name']}} - {{$event['title']}}</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>

</div>

@endsection

@push('page-scripts')
	
@endpush