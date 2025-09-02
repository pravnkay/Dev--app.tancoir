@extends('core::layouts.registry.index')

@section('main-content')

	<div class="space-y-4 mb-4">
		<div class="flex justify-between">
			<div class="self-center">
				{{ Breadcrumbs::render('ramp.apply.index') }}
			</div>
			<div class="self-end"> 
				{{--  --}}
			</div>
		</div>		
		<div class="border-border border-t"></div>
	</div>

	<div class="row">
		<div class="col w-full">
			<div class="uk-card uk-card-body">
			    <h3 class="uk-card-title">List of events you can apply to</h3>
			    <ul class="uk-list uk-list-hyphen mt-4">
					@foreach ($events as $event)
						<li>
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