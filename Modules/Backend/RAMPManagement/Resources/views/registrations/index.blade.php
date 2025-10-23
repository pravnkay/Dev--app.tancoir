@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.registrations'))

@section('action-button')
	{{-- <a type="button" href="{{route('backend.rampmanagement.events.create')}}" class="uk-btn uk-btn-primary self-end">{{__('New Event')}}</a> --}}
@endsection

@section('main-content')

<div class="row">
	
	<div class="col w-full md:w-2/4">
		<select id="event-picker" name="event" class="uk-select" _="on change go to url `{{route('backend.rampmanagement.registrations.index')}}/${me.value}`">
			<option value="">All Events</option>
			@foreach ($all_events as $event)
				<option value="{{$event->id}}" @selected($filtered_event ? $event->id === $filtered_event->id : false) : >{{$event->name}}</option>
			@endforeach
		</select>
	</div>

	

	@if ($slot_summary)

	<div class="col w-full mt-4">
		<div class="row">
			<div class="col w-full md:w-1/4 mb-3">
				<div class="uk-card uk-card-body">
					<h3 class="uk-card-title">{{$slot_summary['filled']}}</h3>
					<p class="mt-4">
						Registration Details
					</p>			
				</div>
			</div>
			<div class="col w-full md:w-1/4 mb-3">
				<div class="uk-card uk-card-body">
					<h3 class="uk-card-title">{{$slot_summary['approved']}}/{{$slot_summary['total']}}</h3>
					<p class="mt-4">
						Participant Details
					</p>			
				</div>
			</div>
		</div>
	</div>
	
	@endif

	<div class="col w-full border-border border-t mt-6 mb-6"></div>

	@if($upload_information)
	<div class="col w-full md:w-1/4 mb-3">
		<div class="uk-alert" data-uk-alert>
			<a href class="uk-alert-close" data-uk-close></a>
			<div class="uk-alert-title">Notice</div>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua.
			</p>
		</div>
	</div>
	<div class="col w-full border-border border-t mt-6 mb-6"></div>
	@endif


</div>

	

	<div class="row">
		<div class="col w-full">
			{!! $dataTable->table([], true) !!}
		</div>
	</div>

	<form id="bulk-delete-form" method="POST" action="{{route('backend.bulk.destroy') }}">
		@csrf
		@method('DELETE')
		<input type="text" name="model" value="{{$model}}" hidden>
	</form>

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}
	
@endpush
