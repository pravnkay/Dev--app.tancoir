@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.participations'))

@section('action-button')
{{--  --}}
@endsection

@section('main-content')

<div class="row">
	<div class="col w-full md:w-1/2">
		<select id="event-picker" name="event" class="uk-select" _="on change go to url `{{route('backend.rampmanagement.participations.index')}}/${me.value}`">
			<option value="">All Events</option>
			@foreach ($all_events as $event)
				<option value="{{$event->id}}" @selected($filtered_event ? $event->id === $filtered_event->id : false) : >{{$event->name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col w-full border-border border-t mt-6 mb-6"></div>
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